<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 会员管理
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_user")
     */
    public function indexAction()
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $this->get('app.user_manager')->findAll(),
        ]);
    }
}