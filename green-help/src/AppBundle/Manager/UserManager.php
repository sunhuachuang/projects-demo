<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserManager implements UserProviderInterface
{
    protected $encodeFactory;
    protected $entityManager;
    protected $repository;
    protected $class;

    public function getEncodeFactory()
    {
        return $this->encodeFactory;
    }

    public function __construct(EncoderFactoryInterface $encoderFactory, EntityManager $em, $class)
    {
        $this->encodeFactory = $encoderFactory;
        $this->entityManager = $em;
        $this->repository = $em->getRepository($class);
        $this->class = $class;
    }

    public function createUser()
    {
        return new $this->class;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function loadUserByUsername($username)
    {
        return $this->repository->findOneByUsername($username);
    }

    //报单中心人数
    public function countDepartment(UserInterface $user)
    {
        $deparment = $user->getReportDepartment();
        $q = $this->repository
           ->createQueryBuilder('u')
           ->select('count(u.id)')
           ->where('u.parent = :id')
           ->andWhere('u.reportDepartment = :department')
           ->setParameter('id', $user->getId())
           ->setParameter('department', $deparment)
           ->getQuery();
        return $q->getSingleScalarResult();
    }

    //直推人数
    public function countReport(UserInterface $user)
    {
        $q = $this->repository
           ->createQueryBuilder('u')
           ->select('count(u.id)')
           ->where('u.parent = :id')
           ->setParameter('id', $user->getId())
           ->getQuery();
        return $q->getSingleScalarResult();
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', $class)
            );
        }
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return $this->class === $class || is_subclass_of($class, $this->$class);
    }

    public function save(UserInterface $user)
    {
        if ($user->getSalt() === null) {
            $user->setSalt(md5(uniqid(null, true)));
        }

        $this->updatePassword($user);
        if (is_array($user->getRoles())) {
            $user->setRoles($user->getRoles());
        } else {
            $user->setRoles(array($user->getRoles()));
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function update(UserInterface $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function changePassword(UserInterface $user, $formData)
    {
        $encoder = $this->getEncoder($user);

        if($encoder->isPasswordValid($user->getPassword(), 'admin', $user->getSalt())) {
            return false;
        }

        $encoderNewPassword = $encoder->encodePassword($formData['newPassword'], $user->getSalt());
        if($formData['type'] === 1) {
            $user->setPassword($encoderNewPassword);
        } elseif($formData['type'] === 2) {
            $user->setPassword($encoderNewPassword);
        }
        $this->update($user);
        return true;
    }

    public function updatePassword(UserInterface $user)
    {
        $password = $user->getPassword();
        $secondPassword = $user->getSecondPassword();
        $encoder = $this->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        $user->setSecondPassword($encoder->encodePassword($secondPassword, $user->getSalt()));
    }

    public function getEncoder(UserInterface $user)
    {
        return $this->encodeFactory->getEncoder($user);
    }

    public function delete(UserInterface $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
