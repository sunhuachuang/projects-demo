<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\News;
use AppBundle\Form\NewsType;

/** 新闻公告管理
 * @Route("/admin/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="admin_news")
     */
    public function indexAction()
    {
        return $this->render('admin/news/index.html.twig', [
            'newses' => $this->getDoctrine()->getRepository('AppBundle:News')->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_news_new")
     */
    public function newAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if($form->isValid()) {
            $this->get('app.common_manager')->save($news);
            return $this->redirectToRoute('admin_news');
        }
        return $this->render('admin/news/new_and_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_news_edit")
     */
    public function editAction(News $news, Request $request)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if($form->isValid()) {
            $this->get('app.common_manager')->save($news);
            return $this->redirectToRoute('admin_news');
        }
        return $this->render('admin/news/new_and_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/do/{action}", name="admin_news_do")
     */
    public function doAction($action, Request $request)
    {
        $newses = $request->get('newses', []);
        $newsesId = [];
        foreach($newses as $key => $value) {
            $newsesId[] = $key;
        }
        if($newsesId) {
            $news = $this->getDoctrine()->getRepository('AppBundle:News')->find(intval($newsesId[0]));
            switch ($action) {
            case 'show':
                $news->setIsShow(true);
                $this->get('app.common_manager')->save($news);
                break;
            case 'noShow':
                $news->setIsShow(false);
                $this->get('app.common_manager')->save($news);
                break;
            case 'top':
                $news->setIsTop(true);
                $this->get('app.common_manager')->save($news);
                break;
            case 'noTop':
                $news->setIsTop(false);
                $this->get('app.common_manager')->save($news);
                break;
            case 'delete':
                $this->get('app.common_manager')->delete($news);
                break;
            }
        }
        return $this->redirectToRoute('admin_news');
    }
}