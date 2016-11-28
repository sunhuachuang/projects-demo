<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TransactionType;
use AppBundle\Entity\Transaction;

//财务管理
class FinanceController extends Controller
{
    /**
     * @Route("/user/finance/{slug}", name="user_finance")
     */
    public function indexAction(Request $request, $slug)
    {
        $param = $this->getDoctrine()->getRepository('AppBundle:Param')->find(intval($slug));
        return $this->render('user/finance/index.html.twig', [
            'wallet' => $this->getUser()->getWallet($param->getValue()),
            'form' => $this->get('app.common_manager')->createForm(TransactionType::class, new Transaction())->createView(),
        ]);
    }
}