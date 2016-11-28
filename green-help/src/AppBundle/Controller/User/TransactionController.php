<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\TransactionType;
use AppBundle\Entity\Transaction;
use AppBundle\Entity\UserWalletHistory;

//交易信息
class TransactionController extends Controller
{
    /**
     * @Route("/user/transaction/{slug}", name="user_transaction", requirements={
     *    "slug": "1|2"
     * })
     */
    public function indexAction(Request $request, $slug)
    {
        return $this->render('user/transaction/index.html.twig', [
            'transactions' => $this->getUser()->getTransactions($slug),
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/user/transaction/new", name="user_transaction_new")
     */
    public function newAction(Request $request)
    {
        $manager = $this->get('app.common_manager');
        $trans = new Transaction;
        $form = $manager->createForm(TransactionType::class, $trans);
        $form->handleRequest($request);
        if($form->isValid()) {
            $trans->setUser($this->getUser());
            if(intval($trans->getType()) === 1) {
                if($trans->getTixian()
                   && $wallet = $this->getDoctrine()->getRepository('AppBundle:Wallet')->find($trans->getTixian())) {
                    if($wallet->getMoney() >= $trans->getMoney()) {
                        $wallet->setMoney($wallet->getMoney() - $trans->getMoney());
                        $walletHistory = new UserWalletHistory();
                        $walletHistory->setWallet($wallet);
                        $walletHistory->setType(2);
                        $walletHistory->setMoney($trans->getMoney());
                        $walletHistory->setMessage('提现');
                        $walletHistory->setStatus('等待匹配');
                        $manager->persist($wallet);
                        $manager->persist($walletHistory);
                    }
                } else {
                    $trans->setTixian(0);
                }
                $trans->setOrderNumber('GO'.time().$this->getUser()->getId());
            } else {
                $trans->setOrderNumber('PO'.time().$this->getUser()->getId());
            }
            $manager->save($trans);
        }

        return $this->redirectToRoute('user_transaction', ['slug' => $trans->getType()]);
    }

    /**
     * @Route("/user/transaction/delete/{id}", name="user_transaction_delete")
     */
    public function delete(Transaction $transaction)
    {
        if($transaction->getUser()->getId() === $this->getUser()->getId() && !$transaction->getMatchFlag()){
            $this->get('app.common_manager')->delete($transaction);
            return new Response('删除成功');
        }
        return new Response('删除失败');
    }

    /**
     * @Route("user/transaction/show/{id}", name="user_transaction_show")
     */
    public function showAction(Transaction $transaction)
    {
        if($transaction->getUser()->getId() === $this->getUser()->getId()){
            return $this->render('user/transaction/show.html.twig', [
                'transaction' => $transaction,
            ]);
        }
        return new Response('失败');
    }

    /**
     * @Route("user/transaction/sure/{id}", name="user_transaction_sure")
     */
    public function sureAction(Transaction $transaction)
    {
        if($transaction->getUser()->getId() === $this->getUser()->getId()
           && $transaction->getStatus() === 0
           && $transaction->getType() === 2){
            $transaction->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();
            return $this->redirectToRoute('user_transaction_show', ['id' => $transaction->getId()]);
        }
        return new Response('失败');
    }

    /**
     * @Route("user/transaction/sure/{id}/get", name="user_transaction_sure_get")
     */
    public function sureGetAction(Transaction $transaction)
    {
        $provideTransaction = $transaction->getMatchProvide();
        if($transaction->getUser()->getId() === $this->getUser()->getId()
           && $transaction->getStatus() === 0
           && $transaction->getType() === 1
           && $provideTransaction->getStatus() === 1){
            $transaction->setStatus(2);
            $provideTransaction = $transaction->getMatchProvide();
            $provideTransaction->setStatus(2);
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->persist($provideTransaction);
            $em->flush();
            return $this->redirectToRoute('user_transaction_show', ['id' => $transaction->getId()]);
        }
        return new Response('失败');
    }
}