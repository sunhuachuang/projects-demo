<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserChangeType;

class UserController extends Controller
{
    /**
     * @Route("/user/info", name="user_info")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserChangeType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $this->get('app.user_manager')->update($user);
            return $this->redirectToRoute('user_info');
        }
        return $this->render('user/info/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/info/tree", name="user_info_tree")
     */
    public function treeAction(Request $request)
    {
        $username = $request->get('username', '');
        if($username) {
            $user = $this->get('app.user_manager')->loadUserByUsername($username);
        } else {
            $user = $this->getUser();
        }

        return $this->render('user/info/tree.html.twig', [
            'user' => $user,
            'username' => $username,
            'number' => $this->get('app.user_manager')->countDepartment($this->getUser()),
        ]);
    }
}