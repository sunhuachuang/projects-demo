<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\GuestType;
use AppBundle\DBAL\Types\UserRoleType;

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
     * @Route("/user/register/{role}", name="user_register", defaults={"role"=null})
     */
    public function registerAction($role)
    {
        $user = new User;
        if ($role === 'guest') {
            $form = $this->createForm(new GuestType(), $user);
        } else {
            $form = $this->createForm(new UserType(), $user);
        }
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $this->get('user_manager')->save($role, $user);
            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('user/security/register.html.twig', array(
            'form'  => $form->createView(),
        ));
    }
    /**
     * @Route("/user/login_check", name="user_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function loginOutAction()
    {
        throw new \Exception("this should never be reached!");
    }

    /**
     * @Route("/user/show/{id}", name="user_show")
     */
    public function showAction(User $user)
    {
        return $this->render('user/security/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("user/info/edit/{id}", name="user_info_edit")
     */
    public function editAction(User $user)
    {
        if ($user->getRoles() === ['ROLE_GUEST']) {
            $form = $this->createForm(new GuestType(), $user);
        } elseif ($user->getRoles() === ['ROLE_USER']) {
            $form = $this->createForm(new UserType(), $user);
        }
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $this->get('user_manager')->save($role, $user);
            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('user/security/edit.html.twig', array(
            'form'  => $form->createView(),
        ));
    }
    /**
     * @Route("user/school-friends", name="user_school_friends")
     */
    public function schoolFriendsAction()
    {
        return $this->render('user/security/school_friends.html.twig', array(
            'users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll(),
        ));
    }
}
