<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Book;

/**
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/", name="cart_index")
     */
    public function indexAction(Request $request)
    {
        if (!$request->getSession()->get('carts')) {
            return $this->render('cart/index.html.twig', array());
        }

        return $this->render('cart/index.html.twig', array(
            'count' => $this->get('cart_manager')->count(),
        ));
    }

    /**
     * @Route("/new/{id}", name="cart_new")
     */
    public function newAction(Book $book, Request $request)
    {
        if ($this->get('cart_manager')->save($book, intval($request->get('cart_number')))) {
            return $this->redirectToRoute('cart_index');
        }
        //return false;
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/delete/{key}", name="cart_delete", defaults={"key"=null})
     */
    public function deleteAction($key)
    {
        $this->get('cart_manager')->delete($key);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/change-number", name="cart_change_number")
     */
    public function changeAction(Request $request)
    {
        $key = $request->get('key');
        $number = $request->get('number');
        return new Response($this->get('cart_manager')->change($key, intval($number)));
    }
}