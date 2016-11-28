<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 交易管理
 * @Route("/admin/transaction")
 */
class TransactionController extends Controller
{
    /**
     * @Route("/", name="admin_transaction")
     */
    public function indexAction()
    {
        return $this->render('admin/transaction/index.html.twig', [
            'transes' => $this->getDoctrine()->getRepository('AppBundle:Transaction')->findBy(['type' => 1, 'matchFlag' => true]),
        ]);
    }
}