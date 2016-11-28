<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 数据库备份
 * @Route("/admin/bak")
 */
class BakController extends Controller
{
    /**
     * @Route("/", name="admin_bak")
     */
    public function indexAction()
    {
        return $this->render('admin/bak/index.html.twig');
    }
}