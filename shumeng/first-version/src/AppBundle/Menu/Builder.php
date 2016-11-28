<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        //$blog = $em->getRepository('AppBundle:Book')->findMostRecent();

        $menu->addChild('Latest Blog Post', array(
            'route' => 'book_show',
            'routeParameters' => array('id' => 1)
        ));

        // create another menu item
        $menu->addChild('About Me', array('route' => 'homepage'));
        // you can also add sub level's to your menu's as follows
        $menu['About Me']->addChild('Edit profile', array('route' => 'homepage'));

        // ... add more children

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('user_information', array(
            'route' => 'user_show',
            'routeParameters' => array('id' => $this->container->get('security.token_storage')->getToken()->getUser()->getId()),
            'label' => '个人信息'));

        $menu->addChild('user_order', array('label' => '订单'));
        $menu['user_order']->addChild('user_order_buying', array('route' => 'book_order_buying', 'label' => '未完出订单'));
        $menu['user_order']->addChild('user_order_done', array('route' => 'book_order_index', 'label' => '全部订单'));

        $menu->addChild('user_book', array('label' => '书本'));

        $menu['user_book']->addChild('user_book_sale', array(
            'route' => 'user_book_list',
            'routeParameters' => array('sale' => 'is-saling'),
            'label' => '在售书本'));

        $menu['user_book']->addChild('user_book_all', array('route' => 'user_book_list', 'label' => '全部书本'));

        $menu->addChild('school_friends', array('route' => 'user_school_friends', 'label' => '同校盟友'));

        return $menu;
    }

    public function leftMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array('class' => 'categorytree')));

        $repository = $this->container->get('doctrine.orm.entity_manager')->getRepository('AppBundle:BookCategory');
        $categories = $repository->findBy(array('parent' => null));

        $this->createTreeMenu($menu, $categories, 1);
        return $menu;
    }

    public function createTreeMenu($menu, $categories, $level)
    {
        foreach ($categories as $category) {
            $hasChildren = !$category->getChildren()->isEmpty();

            $params = array(
                'label' => $category->getName(),
                'attributes' => array('class' => 'level'.$level),
            );
            if (!$hasChildren) {
                $params['route'] = 'book_category_list';
                $params['routeParameters'] = array(
                    'slug' => $category->getSlug(),
                );
            }

            $menu->addChild($category->getName(), $params);

            if($hasChildren) {
                $this->createTreeMenu($menu->getChild($category->getName()), $category->getChildren(), $level+1);
            }
        }

        return $menu;
    }
}