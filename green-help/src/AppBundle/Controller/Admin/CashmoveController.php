<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 货币流向
 * @Route("/admin/cashmove")
 */
class CashmoveController extends Controller
{
    /**
     * @Route("/", name="admin_cashmove")
     */
    public function indexAction()
    {
        return $this->render('admin/cashmove/index.html.twig');
    }
}