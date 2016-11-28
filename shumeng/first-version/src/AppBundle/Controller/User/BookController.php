<?php

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Book;
use AppBundle\Entity\BookCategory;
use AppBundle\Entity\BookImage;
use AppBundle\Form\BookType;

/**
 * @Route("user/book")
 */
class BookController extends Controller
{
    /**
     * @Route("/")
     * @Route("/list/{sale}", name="user_book_list", defaults={"sale"=null})
     */
    public function listAction($sale)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Book');
        if (is_null($sale)) {
            $books = $repository->findAll();
        } else {
            $books = $repository->findBy(array("isSale" => 1));
        }
        return $this->render('user/book/list.html.twig', array(
            'books' => $books,
        ));
    }

    /**
     * @Route("/new", name="user_book_new")
     */
    public function newAction(Request $request)
    {
        $book = new Book();

        //most three images
        // $book->addBookImage(new BookImage);
        // $book->addBookImage(new BookImage);
        // $book->addBookImage(new BookImage);

        $form = $this->createForm(new BookType(), $book);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('book_manager')->save($book);
            return $this->redirectToRoute('user_book_list');
        }
        return $this->render('user/book/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}", name="user_book_edit")
     */
    public function editAction(Book $book, Request $request)
    {
        $form = $this->createForm(new BookType(), $book);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('book_manager')->save($book);
            return $this->redirectToRoute('user_book_list');
        }
        return $this->render('user/book/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="user_book_delete")
     * @Security("book.isAble(user)")
     */
    public function deleteAction(Book $book, Request $request)
    {
        //$form = $this->createDeleteForm($book);
        //$form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        //}
        return $this->redirectToRoute('user_book_list');
    }

    /**
     * @Route("/is_sale/{id}", name="user_book_is_sale")
     */
    public function saleAction(Book $book)
    {
        $em = $this->getDoctrine()->getManager();
        $book->setIsSale(1);
        $em->persist($book);
        $em->flush();
        return $this->redirectToRoute('user_book_list');
    }

    /**
     * @Route("/book-category-change", name="user_book_category_change")
     */
    public function categoryChangeAction(Request $request)
    {
        $bookCategories = $this->getDoctrine()->getRepository('AppBundle:BookCategory')
            ->find($request->get('id'))->getChildren();
        $array = array();
        foreach ($bookCategories as $bookCategory) {
            $array[$bookCategory->getId()] = array('id' => $bookCategory->getId(), 'name' => $bookCategory->getName());
        }
        return new JsonResponse($array);
    }
}
