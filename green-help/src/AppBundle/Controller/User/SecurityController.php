<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserPasswordType;
use AppBundle\Form\UserType;

class SecurityController extends Controller
{
    /**
     * @Route("/user/login", name="user_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("user/login_check", name="user_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("user/logout", name="user_logout")
     */
    public function loginOutAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("user/change-password", name="user_change_password")
     */
    public function changeAction(Request $request)
    {
        $error = '';
        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if($form->isValid()) {
            $formData = $form->getData();
            if($this->get('app.user_manager')->changePassword($this->getUser(), $formData)) {
                return $this->redirectToRoute('user_change_password');
            }
            $error = '旧密码错误!';
        }
        return $this->render('user/security/password.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("user/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $parentName = $user->getParentName();
            $manager = $this->get('app.user_manager');
            $parent = $manager->loadUserByUsername($parentName);
            if($parent) {
                $user->setParent($parent);
                $this->get('app.user_manager')->save($user);
                return $this->redirectToRoute('user_register');
            }
        }

        return $this->render('user/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("register/{id}", name="user_register_open")
     */
    public function registerOpenAction(Request $request, User $parent)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $parentName = $user->getParentName();
            $manager = $this->get('app.user_manager');
            if($parent) {
                $user->setParent($parent);
                $this->get('app.user_manager')->save($user);
                return $this->redirectToRoute('user_login');
            }
        }

        return $this->render('user/security/register_open.html.twig', [
            'form' => $form->createView(),
            'user' => $parent,
        ]);
    }
}
