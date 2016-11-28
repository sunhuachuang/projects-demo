<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class CommonManager
{
    protected $formFactory;
    protected $entityManager;
    protected $repository;
    protected $class;

    public function __construct(EntityManager $em, FormFactory $formFactory)
    {
        $this->entityManager = $em;
        $this->formFactory = $formFactory;

    }

    public function setClass($class)
    {
        $this->class = $class;
        $this->repository = $em->getRepository($class);
        return $this;
    }

    public function createEntity()
    {
        return new $this->class;
    }

    public function createForm($formType, $class = null)
    {
        if(is_null($class)) {
            $class = $this->createEntity();
        }
        return $this->formFactory->create($formType, $class);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function find($id)
    {
        return $this->repository->find($id);
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
}