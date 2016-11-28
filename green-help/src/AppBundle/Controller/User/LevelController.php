<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\LevelApplication;

//市场管理
class LevelController extends Controller
{
    /**
     * @Route("/user/level/{level}", name="user_level")
     */
    public function indexAction($level)
    {
        $needNumber = 500;
        $levelName = $this->getDoctrine()->getRepository('AppBundle:Param')->find(intval($level));
        if($level && $levelName->getValue() === '正式会员') {
            $needNumber = 0;
        }
        return $this->render('user/level/index.html.twig', [
            'number' => $this->get('app.user_manager')->countDepartment($this->getUser()),
            'level' => $level,
            'needNumber' => $needNumber,
            'isLeveling' => $this->getUser()->isLevelApplication($levelName->getValue()),
            'isOK' => $this->getUser()->getLevel() === $levelName->getValue() ? true : false,
        ]);
    }

    /**
     * @Route("/user/level/{level}/apply", name="user_level_apply")
     */
    public function applyAction($level)
    {
        $needNumber = 500;
        $levelName = $this->getDoctrine()->getRepository('AppBundle:Param')->find(intval($level));
        if($level && $levelName->getValue() === '正式会员') {
            $needNumber = 0;
        }
        $user = $this->getUser();
        $number = $this->get('app.user_manager')->countDepartment($user);
        if($number < $needNumber) {
            return $this->redirectToRoute('user_level', ['level' => $level]);
        }
        $application = new LevelApplication();
        $application->setNumber($number);
        $application->setUser($user);
        $application->setLevel($levelName->getValue());
        $application->setOldLevel($user->getLevel());
        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        return $this->redirectToRoute('user_level', ['level' => $level]);
    }
}
