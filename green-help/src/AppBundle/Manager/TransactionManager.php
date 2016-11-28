<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TransactionManager
{
    protected $formFactory;
    protected $entityManager;
    protected $repository;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->entityManager = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($class);

    }

    public function createEntity()
    {
        return new $this->class;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findOneByOrderNumber($orderNumber)
    {
        return $this->repository->findOneByOrderNumber($orderNumber);
    }

    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    //超时\排队\锁定
    public function checkTransaction()
    {
        $paramRepository = $this->entityManager->getRepository('AppBundle:Param');
        $nowTime = time();
        $inDay = $paramRepository->findOneByType('inDay')->getValue();
        $provideTime = $paramRepository->findOneByType('provideTime')->getValue();//打款超时锁定时间
        $getMoneyTime = $paramRepository->findOneByType('getMoneyTime')->getValue();//收款超时锁定时间
        $finishDay = $paramRepository->findOneByType('finishDay')->getValue();//交易完成后锁定取出时间
        $matchs = $this->findAll();
        foreach($matchs as $match) {
            $createdTime = time($match->getCreatedAt());
            $updatedTime = time($match->getUpdatedAt());
            if(ceil(($nowTime - $createdTime)/86400) >= intval($inDay)) { //是否排完队
                $match->setIsQueue(true);
                $this->entityManager->persist($match);
            }
            if($match->getMatchFlag()) {
                if($match->getStatus() == 0 && ceil(($nowTime - $updatedTime)/3600) >= intval($provideTime)) { //打款超时
                    $match->setIsLock(true);
                }
                if($match->getStatus() == 1 && ceil(($nowTime - $updatedTime)/3600) >= intval($finishDay)) { //收款超时
                    $match->setIsLock(true);
                }
            }
        }

        $this->entityManager->flush();
        return true;
    }
}