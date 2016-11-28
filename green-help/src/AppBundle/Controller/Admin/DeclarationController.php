<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DeclarateApplication;

/** 报单申请管理
 * @Route("/admin/declaration")
 */
class DeclarationController extends Controller
{
    /**
     * @Route("/", name="admin_declaration")
     */
    public function showAction()
    {
        return $this->render('admin/declaration/index.html.twig', [
            'applications' => $this->getDoctrine()->getRepository('AppBundle:DeclarateApplication')->findAll(),
        ]);
    }

    /**
     * @Route("/apply/{id}/{act}", name="admin_declaration_application_apply")
     */
    public function applyAction(DeclarateApplication $application, $act)
    {
        $user = $application->getUser();
        $em = $this->getDoctrine()->getManager();
        if(intval($act) === 2) {
            $application->setStatus(2);
            $user->setDeclarateStatus(0);
            $report = date('ymd').$user->getId().$application->getId();
            $user->setReportDepartment($report);
            foreach($user->getChildren() as $child) {
                $child->setReportDepartment($report);
                $em->persist($child);
            }
        } else {
            $application->setStatus(3);
            $user->setDeclarateStatus(2);
        }
        $em->persist($application);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin_declaration');
    }

    /**
     * @Route("/delete/{id}", name="admin_declaration_application_delete")
     */
    public function deleteAction(DeclarateApplication $application)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();
        return $this->redirectToRoute('admin_declaration');
    }
}