<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 当期出纳
 * @Route("/admin/cashier")
 */
class CashierController extends Controller
{
    /**
     * @Route("/", name="admin_cashier")
     */
    public function indexAction()
    {
        return $this->render('admin/cashier/index.html.twig');
    }
}