<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\BookOrder;

class BookOrderManager
{
    protected $objectManager;
    protected $repository;
    protected $tokenStorage;
    protected $session;

    public function __construct(ObjectManager $objectManager, TokenStorageInterface $tokenStorage, Session $session)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $objectManager->getRepository('AppBundle:BookOrder');
        $this->tokenStorage  = $tokenStorage;
        $this->session       = $session;
    }

    public function save($key, BookOrder $bookOrder)
    {
        if(!$carts = $this->session->get('carts')) {
            return false;
        }

        if (!is_null($key) && $cart = $carts[$key]) {
            $book = $this->objectManager->getRepository('AppBundle:Book')->find($cart['book']->getId());
            if ($book->getNumber() < $cart['number']) {
                return false;
            }
            $bookOrder->setBook($book);
            $bookOrder->setNumber($cart['number']);
            $bookOrder->setUser($this->tokenStorage->getToken()->getUser());

            $book->setNumber($book->getNumber() - $cart['number']);
            $this->objectManager->persist($bookOrder);//
            $this->objectManager->persist($book);
            $this->objectManager->flush();
            return true;
        }
    }

    public function findBuying()
    {

    }
}