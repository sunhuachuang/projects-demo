<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Admin;
use AppBundle\Form\AdminPasswordType;
use AppBundle\Form\AdminType;

class SecurityController extends Controller
{
    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("admin/login_check", name="admin_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("admin/logout", name="admin_logout")
     */
    public function loginOutAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("admin/change-password", name="admin_change_password")
     */
    public function changeAction(Request $request)
    {
        $error = '';
        $form = $this->createForm(AdminPasswordType::class);
        $form->handleRequest($request);
        if($form->isValid()) {
            $formData = $form->getData();
            if($this->get('app.admin_manager')->changePassword($this->getUser(), $formData)) {
                return $this->redirectToRoute('admin_change_password');
            }
            $error = '旧密码错误!';
        }
        return $this->render('admin/security/password.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("admin/register", name="admin_register")
     */
    public function registerAction(Request $request)
    {
        $user = new Admin();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $parentName = $user->getParentName();
            $manager = $this->get('app.admin_manager');
            $parent = $manager->loadUserByUsername($parentName);
            if($parent) {
                $user->setParent($parent);
                $this->get('app.admin_manager')->save($user);
                return $this->redirectToRoute('admin_register');
            }
        }

        return $this->render('admin/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
