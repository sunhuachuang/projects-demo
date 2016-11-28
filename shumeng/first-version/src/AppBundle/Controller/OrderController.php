<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Form\OrderType;

/**
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="order_index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
        ));
    }

    /**
     * @Route("/new/{key}", name="order_new", defaults={"key"=null})
     */
    public function newAction(Request $request, $key)
    {
        $order = new Order();
        $form = $this->createForm(new OrderType(), $order);
        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($this->get('order_manager')->save($key, $order)) {
                return $this->redirectToRoute('user_homepage');
            }
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('order/new.html.twig', array(
            'form' => $form->createView(),
            'key'  => $key,
        ));
    }
}
