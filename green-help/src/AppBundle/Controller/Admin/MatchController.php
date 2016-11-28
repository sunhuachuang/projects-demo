<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/** 手动匹配
 * @Route("/admin/match")
 */
class MatchController extends Controller
{
    /**
     * @Route("/", name="admin_match")
     */
    public function indexAction()
    {
        $this->get('app.transaction_manager')->checkTransaction();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Transaction');
        return $this->render('admin/match/index.html.twig', [
            'gets' => $repository->findByType(1),
            'provides' => $repository->findByType(2),
        ]);
    }

    /**
     * @Route("/action", name="admin_match_action")
     */
    public function match(Request $request)
    {
        $manager = $this->get('app.transaction_manager');

        $get = $request->get('get');
        $provide = $request->get('provide');
        $getObject = $manager->findOneByOrderNumber($get);
        $provideObject = $manager->findOneByOrderNumber($provide);
        if($getObject
           && $provideObject
           && $getObject->getMoney() === $provideObject->getMoney()
           && !$getObject->getMatchFlag()
           && !$provideObject->getMatchFlag()) {
            $getObject->setMatchProvide($provideObject);
            $provideObject->setMatchGet($getObject);
            $manager->persist($getObject);
            $manager->persist($getObject);
            $manager->flush();
        }
        return $this->redirectToRoute('admin_match');
    }
}