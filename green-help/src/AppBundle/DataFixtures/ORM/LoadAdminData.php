<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Admin;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 */
class LoadAdminData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $user = new Admin();
        $user->setUsername('admin');
        $user->setPassword('admin');
        $user->setSecondPassword('admin');
        $user->setEmail('admin@example.com');
        $user->setPhone('234254');
        $user->setRoles(array('ROLE_SUPER'));
        $user->setSalt('5059a401c5f283c558580fbf034cdd48');
        $userManager = $this->container->get('app.admin_manager');
        $userManager->save($user);

        $this->addReference('admin', $user);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
