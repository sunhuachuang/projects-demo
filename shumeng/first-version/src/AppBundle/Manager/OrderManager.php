<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Order;

class OrderManager
{
    protected $objectManager;
    protected $repository;
    protected $tokenStorage;
    protected $session;

    public function __construct(ObjectManager $objectManager, TokenStorageInterface $tokenStorage, Session $session)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $objectManager->getRepository('AppBundle:Order');
        $this->tokenStorage  = $tokenStorage;
        $this->session       = $session;
    }

    public function save($key, Order $order)
    {
        if(!$carts = $this->session->get('carts')) {
            return false;
        }

        if (!is_null($key) && $cart = $carts[$key]) {
            $book = $this->objectManager->getRepository('AppBundle:Book')->find($cart['book']->getId());
            if ($book->getNumber() < $cart['number']) {
                return false;
            }
            $order->setBook($book);
            $order->setNumber($cart['number']);
            $order->setUser($this->tokenStorage->getToken()->getUser());

            $book->setNumber($book->getNumber() - $cart['number']);
            //die(dump($order));
            $this->objectManager->persist($order);//
            $this->objectManager->persist($book);
            $this->objectManager->flush();
            return true;
        }
    }
}