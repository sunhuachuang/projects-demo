<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Param;

/** 参数设定
 * @Route("/admin/param")
 */
class ParamController extends Controller
{
    /**
     * @Route("/", name="admin_param")
     */
    public function indexAction()
    {
        return $this->render('admin/param/index.html.twig', [
            'params' => $this->getParams(),
        ]);
    }

    /**
     * @Route("/edit", name="admin_param_edit")
     */
    public function editAction(Request $request)
    {
        $form = $request->get('form');
        $objectParams = $this->getObjectParams();
        $em = $this->getDoctrine()->getManager();

        foreach($form as $key => $value) {
            $param = $objectParams[$key];
            if(is_array($param)) {
                $arrayValues = explode('|', $value);
                if($param) {
                    $preArrayValues = [];
                    foreach($param as $p) {
                        $preArrayValues[] = $p->getValue();
                        if(!in_array($p->getValue(), $arrayValues)) {
                            $em->remove($p);
                        }
                    }
                    foreach($arrayValues as $arrayValue) {
                        if(!in_array($arrayValue, $preArrayValues)) {
                            $param = new Param();
                            $param->setValue($arrayValue);
                            $param->setType($key);
                            $em->persist($param);
                        }
                    }
                } else {
                    foreach($arrayValues as $arrayValue) {
                        $param = new Param();
                        $param->setValue($arrayValue);
                        $param->setType($key);
                        $em->persist($param);
                    }
                }
            } else {
                if(!$param) {
                    $param = new Param();
                }

                if($param->getValue() !== $value) {
                    $param->setValue($value);
                    $param->setType($key);
                    $em->persist($param);
                }
            }
        }

        $em->flush();

        return $this->redirectToRoute('admin_param');
    }

    private function getParams()
    {
        $params = $this->getObjectParams();
        $params['levels'] = $this->getValues($params['levels']);
        $params['provideOrGets'] = $this->getValues($params['provideOrGets']);
        $params['managerMoneys'] = $this->getValues($params['managerMoneys']);
        $params['jingliMoneys'] = $this->getValues($params['jingliMoneys']);
        $params['touziMoneys'] = $this->getValues($params['touziMoneys']);
        $params['banks'] = $this->getValues($params['banks']);
        $params['moneyNames'] = $this->getValues($params['moneyNames']);

        return $params;
    }

    private function getObjectParams()
    {
        $params = [];
        $repository = $this->getDoctrine()->getRepository('AppBundle:Param');
        $params['levels'] = $repository->findByType('levels');
        $params['registerMoney'] = $repository->findOneByType('registerMoney');
        $params['provideOrGets'] = $repository->findByType('provideOrGets');
        $params['staticMoney'] = $repository->findOneByType('staticMoney');
        $params['staticAddMoney'] = $repository->findOneByType('staticAddMoney');
        $params['outDay'] = $repository->findOneByType('outDay');
        $params['tuijian'] = $repository->findOneByType('tuijian');
        $params['tuijianAdd'] = $repository->findOneByType('tuijianAdd');

        $params['managerMoneys'] = $repository->findByType('managerMoneys');
        $params['jingliMoneys'] = $repository->findByType('jingliMoneys');
        $params['touziMoneys'] = $repository->findByType('touziMoneys');

        $params['maxMoney'] = $repository->findOneByType('maxMoney');
        $params['inDay'] = $repository->findOneByType('inDay');
        $params['provideTime'] = $repository->findOneByType('provideTime');
        $params['getMoneyTime'] = $repository->findOneByType('getMoneyTime');
        $params['finishDay'] = $repository->findOneByType('finishDay');
        $params['networkMoney'] = $repository->findOneByType('networkMoney');
        $params['moneyNames'] = $repository->findByType('moneyNames');
        $params['userRecharge'] = $repository->findOneByType('userRecharge');
        $params['minMoney'] = $repository->findOneByType('minMoney');
        $params['userNumber'] = $repository->findOneByType('userNumber');

        $params['closeTip'] = $repository->findOneByType('closeTip');

        $params['banks'] = $repository->findByType('banks');

        $params['bankMessage'] = $repository->findOneByType('bankMessage');
        $params['registerMessage'] = $repository->findOneByType('registerMessage');

        $params['login'] = $repository->findOneByType('login');
        $params['front'] = $repository->findOneByType('front');
        $params['match'] = $repository->findOneByType('match');

        return $params;
    }

    private function getValues($array)
    {
        $values = [];
        foreach($array as $value) {
            $values[] = $value->getValue();
        }
        return $values;
    }
}