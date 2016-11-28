<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BookCategory;
use AppBundle\Form\BookCategoryType;

/**
 * @Route("/book-category")
 */
class BookCategoryController extends Controller
{
    /**
     * @Route("/")
     * @Route("/list", name="admin_book_category_list")
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:BookCategory')->findBy(array('parent' => null));
        return $this->render('admin/book_category/list.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/new", name="admin_book_category_new")
     */
    public function newAction()
    {
        $bookCategory = new BookCategory();
        $form = $this->createForm(new BookCategoryType(), $bookCategory);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bookCategory);
            $em->flush();
            return $this->redirectToRoute('admin_book_category_list');
        }
        return $this->render('admin/book_category/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit/{book_id}", name="admin_book_category_edit")
     */
    public function editAction()
    {
        return $this->render('admin/book_category/edit.html.twig', array());
    }

    /**
     * @Route("/delete/{book_id}", name="admin_book_category_delete")
     */
    public function deleteAction()
    {
        return $this->render('admin/book_category/list.html.twig', array());
    }
}
