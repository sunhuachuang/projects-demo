<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DeclarateApplication;

//报单
class DeclarationController extends Controller
{
    /**
     * @Route("/user/declaration/show", name="user_declaration_show")
     */
    public function showAction()
    {
        $user = $this->getUser();
        return $this->render('user/declaration/show.html.twig', [
            'number' => $this->get('app.user_manager')->countReport($user),
            'needNumber' => 1,
        ]);
    }

    /**
     * @Route("/user/declaration/apply", name="user_declaration_apply")
     */
    public function applyAction(Request $request)
    {
        $user = $this->getUser();
        $manager = $this->get('app.user_manager');
        $groupNumber = $manager->countDepartment($user);
        $childrenNumber = $manager->countReport($user);

        $application = new DeclarateApplication();
        $application->setUser($user);
        $application->setStatus(1);
        $application->setChildrenNumber($childrenNumber);
        $application->setGroupNumber($groupNumber);
        $user->setDeclarateStatus(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_declaration_show');
    }
}