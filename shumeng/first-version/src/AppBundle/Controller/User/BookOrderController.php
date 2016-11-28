<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BookOrder;
use AppBundle\Form\BookOrderType;

/**
 * @Route("/user/book-order")
 */
class BookOrderController extends Controller
{
    /**
     * @Route("/", name="book_order_index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('user/book_order/index.html.twig', array(
        ));
    }

    /**
     * @Route("/buying", name="book_order_buying")
     */
    public function buyAction(Request $request)
    {
        return $this->render('user/book_order/buying.html.twig', array(
            'book_orders' => $this->get('book_order_manager')->findBuying(),
        ));
    }

    /**
     * @Route("/new/{key}", name="book_order_new", defaults={"key"=null})
     */
    public function newAction(Request $request, $key)
    {
        $bookOrder = new BookOrder();
        $form = $this->createForm(new BookOrderType(), $bookOrder);
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($this->get('book_order_manager')->save($key, $bookOrder)) {
                return $this->redirectToRoute('book_order_index');
            }
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('user/book_order/new.html.twig', array(
            'form' => $form->createView(),
            'key'  => $key,
        ));
    }

    /**
     * @Route("/show/{id}", name="book_order_show")
     */
    public function showAction(BookOrder $bookOrder)
    {
        return $this->render('user/book_order/show.html.twig', array(
            'book_order' => $bookOrder,
        ));
    }
}
