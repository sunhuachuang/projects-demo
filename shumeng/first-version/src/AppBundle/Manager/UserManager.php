<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\DBAL\Types\UserRoleType;
use AppBundle\DBAL\Types\UserPositionType;

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

    public function find($id)
    {
        $q = $this->repository
            ->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id',$id)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an AppBundle:Administrator object identified by "%s".',
                $id
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function loadUserByUsername($username)
    {
        $q = $this->repository
            ->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an AppBundle:Administrator object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
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
        return $this->class === $class || is_subclass_of($class,$this->$class);
    }

    public function save($role, UserInterface $user)
    {
        if ($user->getSalt() === null) {
            $user->setSalt(md5(uniqid(null,true)));
        }

        $this->updatePassword($user);
        if ($user->getRoles()) {
            $user->setRoles($user->getRoles());
        } elseif (is_null($role)) {
            $user->setRoles([UserRoleType::USER]);
        } else {
            $user->setRoles([UserRoleType::GUEST]);
        }
        if (!$user->getPosition() && is_null($role)) {
            $user->setPosition(UserPositionType::FIRST);
        }
        $user->setLastLogin(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password,$user->getSalt()));
        }
    }

    public function getEncoder(UserInterface $user)
    {
        return $this->encodeFactory->getEncoder($user);
    }
}
