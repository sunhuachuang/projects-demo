<?php

namespace AppBundle\Manager;

use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Book;

class CartManager
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function save(Book $book, $number)
    {
        if ($book->getNumber() < $number) {
            return false;
        }

        $cartNew = array('number' => $number, 'book'=> $book);

        // set and get session attributes
        if (!$carts = $this->session->get('carts')) {
            $carts = array();
        }

        $is_exist = false;
        foreach ($carts as $key => $cart) {
            if($cart['book']->getId() === $book->getId()) {
                $carts[$key]['number'] += $number;
                $is_exist = true;
            }
        }
        if (!$is_exist) {
            $carts[] = $cartNew;
        }
        $this->session->set('carts', $carts);

        return true;
    }

    public function count()
    {
        $carts = $this->session->get('carts');
        $kindTotal = count($carts);
        $numberTotal = 0;
        $priceTotal = 0.00;
        foreach ($carts as $cart) {
            $numberTotal += $cart['number'];
            $priceTotal  += $cart['number'] * $cart['book']->getShopPrice();
        }

        return array(
            'kind_total'   => $kindTotal,
            'number_total' => $numberTotal,
            'price_total'  => $priceTotal,

        );
    }

    public function delete($key = null)
    {
        if (!$carts = $this->session->get('carts')) {
            return true;
        }
        if (is_null($key)) {
            $this->session->remove('carts');
            return true;
        }

        unset($carts[$key]);
        $this->session->set('carts', $carts);
    }

    public function change($key, $number)
    {
        if (!$carts = $this->session->get('carts')) {
            return 'no cart';
        }
        if ($number < 1) {
            $this->delete($key);
            return 'delete ok';
        }
        if ($number > $carts[$key]['book']->getNumber()) {
            return 'over number! too big!';
        }
        $carts[$key]['number'] = $number;
        $this->session->set('carts', $carts);
    }
}