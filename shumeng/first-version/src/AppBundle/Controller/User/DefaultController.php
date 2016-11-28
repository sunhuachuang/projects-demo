<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/user", name="user_homepage")
     */
    public function indexAction(Request $request)
    {

        return $this->render('user/default/index.html.twig', array(
        ));
    }
}