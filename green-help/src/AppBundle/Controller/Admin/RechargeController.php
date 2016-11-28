<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Recharge;
use AppBundle\Form\RechargeType;
use AppBundle\Entity\UserWallet;
use AppBundle\Entity\UserWalletHistory;

/** 充值管理
 * @Route("/admin/recharge")
 */
class RechargeController extends Controller
{
    /**
     * @Route("/", name="admin_recharge")
     */
    public function indexAction(Request $request)
    {
        $recharge = new Recharge();
        $form = $this->createForm(RechargeType::class, $recharge);
        $form->handleRequest($request);
        if($form->isValid()) {
            $user = $this->get('app.user_manager')->loadUserByUsername($recharge->getUsername());
            if($user) {
                $recharge->setUser($user);
                $recharge->setAdmin($this->getUser());
            }
            $this->get('app.common_manager')->save($recharge);
            return $this->redirectToRoute('admin_recharge');
        }
        return $this->render('admin/recharge/index.html.twig', [
            'recharges' => $this->getDoctrine()->getRepository('AppBundle:Recharge')->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sure", name="admin_recharge_sure")
     */
    public function sureAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Recharge');
        $ids = $request->get('form');
        $em = $this->getDoctrine()->getManager();

        foreach($ids as $key => $value) {
            $recharge = $repository->find(intval($key));
            if($recharge) {
                $em = $this->sureRecharge($recharge, $em);
            }
        }
        $em->flush();
        return $this->readirectToRoute('admin_recharge');
    }

    /**
     * @Route("/sure/{id}", name="admin_recharge_sure_id")
     */
    public function sureIdAction(Recharge $recharge)
    {
        $em = $this->getDoctrine()->getManager();
        $em = $this->sureRecharge($recharge, $em);
        $em->flush();
        return $this->redirectToRoute('admin_recharge');
    }

    private function sureRecharge($recharge, $em)
    {
        $recharge->setSureFlag(true);
        $money = $recharge->getMoney();
        $name = $recharge->getType()->getValue();
        $user = $recharge->getUser();
        //wallet and wallet history
        $wallet = $this->getDoctrine()->getRepository('AppBundle:UserWallet')->findOneBy(['name' => $name,'user' => $user]);
        if(!$wallet) {
            $wallet = new UserWallet();
            $wallet->setName($name);
            $wallet->setUser($user);
        }

        $wallet->setMoney($wallet->getMoney() + $money);

        $walletHistory = new UserWalletHistory();
        $walletHistory->setWallet($wallet);
        $walletHistory->setType(1);
        $walletHistory->setMoney($money);
        $walletHistory->setMessage('充值');
        $walletHistory->setStatus('交易完成');

        $em->persist($wallet);
        $em->persist($walletHistory);
        $em->persist($recharge);
        return $em;
    }
}