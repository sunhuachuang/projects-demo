<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\LevelApplication;
use AppBundle\Entity\User;
use AppBundle\Form\UserLevelType;

/** 晋级管理
 * @Route("/admin/level")
 */
class LevelController extends Controller
{
    /**
     * @Route("/", name="admin_level")
     */
    public function indexAction()
    {
        return $this->render('admin/level/index.html.twig', [
            'users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="admin_level_show")
     */
    public function showAction(User $user, Request $request)
    {
        $oldLevel = $request->get('oldLevel', '');
        $diff = $request->get('diff', '');

        $form = $this->createForm(UserLevelType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $application = new LevelApplication();
            $application->setUser($user);
            $application->setIsUser(false);
            $application->setOldLevel($oldLevel);
            $application->setLevel($user->getLevel());
            $application->setApproveFlag(true);
            $application->setNumber($this->get('app.user_manager')->countDepartment($user));

            //计算差额
            if($diff){

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($application);
            $em->flush();
            return $this->redirectToRoute('admin_level_show', ['id' => $user->getId()]);
        }
        return $this->render('admin/level/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'applications' => $this->getDoctrine()->getRepository('AppBundle:LevelApplication')->findAll(),
        ]);
    }

    /**
     * @Route("/application", name="admin_level_application")
     */
    public function applyAction()
    {
        return $this->render('admin/level/apply.html.twig', [
            'applications' => $this->getDoctrine()->getRepository('AppBundle:LevelApplication')->findAll(),
        ]);
    }

    /**
     * @Route("/application/apply/{id}", name="admin_level_application_apply")
     */
    public function applyDoAction(LevelApplication $application, Request $request)
    {
        $user = $application->getUser();
        $diff = $request->get('diff', '');

        $form = $this->createForm(UserLevelType::class, $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $application->setApproveFlag(true);

            //计算差额
            if($diff){

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($application);
            $em->flush();
            return $this->redirectToRoute('admin_level_show', ['id' => $user->getId()]);
        }
        return $this->render('admin/level/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'applications' => $this->getDoctrine()->getRepository('AppBundle:LevelApplication')->findAll(),
        ]);
    }

    /**
     * @Route("/application/delete/{id}", name="admin_level_application_delete")
     */
    public function deleteAction(LevelApplication $application)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();
        return $this->redirectToRoute('admin_level_application');
    }


    private function diff($user, $level)
    {}
}