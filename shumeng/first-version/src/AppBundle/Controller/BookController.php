<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Book;
use AppBundle\Entity\BookCategory;

/**
* @Route("/book")
*/
class BookController extends Controller
{
    /**
     * @Route("/", name="book_index")
     */
    public function indexAction()
    {
        //get three new and hot
        $number = 3;
        $repository = $this->getDoctrine()->getRepository('AppBundle:Book');
        return $this->render('book/index.html.twig', array(
            'new_books' => $repository->findBy(array('isSale' => 1), array('id' => 'DESC'), $number),
            'hot_books' => $repository->findBy(array('isSale' => 1), array('clickCount' => 'DESC'), $number),
        ));
    }

    /**
     * @Route("/show/{id}", name="book_show")
     */
    public function showAction(Book $book, Request $request)
    {
        return $this->render('book/show.html.twig', array(
            'book' => $book,
        ));
    }

    /**
     * @Route("/category/{slug}", name="book_category_list")
     */
    public function listAction(BookCategory $bookCategory)
    {
        return $this->render('book/category_list.html.twig', array(
            'book_category' => $bookCategory,
        ));
    }

    /**
     * @Route("/search", name="book_search")
     */
    public function searchAction(Reuqire $require)
    {
        return $this->render('book/search.html.twig', array(
            'books' => $this->getDoctrine()->getRepository('AppBundle:Book')->findBy(array(
                $require->get('search_kind') => '*'.$reuqire->get('serach_value').'*',
                )),
        ));
    }
}
