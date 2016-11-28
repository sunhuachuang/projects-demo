<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function userLevelMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        //access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $levels = $em->getRepository('AppBundle:Param')->findByType('levels');
        foreach($levels as $level) {
            $menu->addChild($level->getValue().'申请', array(
                'route' => 'user_level',
                'routeParameters' => array('level' => $level->getId())
            ));
        }

        return $menu;
    }

    public function userFinanceMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        //access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $levels = $em->getRepository('AppBundle:Param')->findByType('moneyNames');
        foreach($levels as $level) {
            $menu->addChild($level->getValue().'钱包', array(
                'route' => 'user_finance',
                'routeParameters' => array('slug' => $level->getId())
            ));
        }
        return $menu;
    }
}