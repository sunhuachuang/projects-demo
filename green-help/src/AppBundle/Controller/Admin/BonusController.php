<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 奖金查询
 * @Route("/admin/bonus")
 */
class BonusController extends Controller
{
    /**
     * @Route("/", name="admin_bonus")
     */
    public function indexAction()
    {
        return $this->render('admin/bonus/index.html.twig');
    }
}