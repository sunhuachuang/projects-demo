<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Form\TransactionType;
use AppBundle\Entity\Transaction;

/**
 * @Route("/user")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="user_homepage")
     */
    public function indexAction()
    {
        $q = $this->getDoctrine()->getRepository('AppBundle:Contact')
           ->createQueryBuilder('u')
           ->select('count(u.id)')
           ->where('u.readFlag = false')
           ->andWhere('u.username = :username')
           ->setParameter('username', $this->getUser()->getUsername())
           ->getQuery();
        $number = $q->getSingleScalarResult();

        return $this->render('user/home/index.html.twig', [
            'messageNumber' => $number,
            'form' => $this->get('app.common_manager')->createForm(TransactionType::class, new Transaction())->createView(),
            'walletNames' => $this->getDoctrine()->getRepository('AppBundle:Param')->findByType('moneyNames'),
        ]);
    }

    /**
     * @Route("/about-us", name="user_about_us")
     */
    public function aboutAction()
    {
        return $this->render('user/home/about_us.html.twig');
    }

    /**
     * @Route("/news", name="user_news")
     */
    public function newsAction()
    {
        return $this->render('user/home/news.html.twig', [
            'newses' =>  $this->getDoctrine()->getRepository('AppBundle:News')->findBy(['isShow' => true], ['isTop' => 'desc']),
        ]);
    }

    /**
     * @Route("/contact", name="user_contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('user/home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/contact/list", name="user_contact_list")
     */
    public function listAction()
    {
        return $this->render('user/home/contact_list.html.twig', [
            'contacts' => $this->getDoctrine()->getRepository('AppBundle:Contact')
                               ->findByUsername($this->getUser()->getUsername()),
        ]);
    }

    /**
     * @Route("/contact/{id}/show", name="user_contact_show")
     */
    public function showAction(Contact $contact)
    {
        if($contact->getUsername() !== $this->getUser()->getUsername()) {
            return redirectToRoute('user_contact_list');
        };

        $contact->setReadFlag(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

        return $this->render('user/home/contact_show.html.twig', [
            'contact' => $contact,
        ]);
    }
}

