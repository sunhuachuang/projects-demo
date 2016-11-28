<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\BookCategory;

/**
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 */
class LoadBookCategoryData implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $resource = $this->container->get('kernel')->getRootDir() . '/Resources/book_category_definition.yml';
        $bookCategorys = Yaml::parse(file_get_contents($resource));

        foreach ($bookCategorys as $name => $data) {
            $this->persistBookCategory(null, $name, $data, $manager);
        }

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }

    private function persistBookCategory($parent, $name, $data, $manager)
    {
        $bookCategory = new BookCategory();
        $bookCategory->setName($name);
        $bookCategory->setSlug($data['slug']);
        $bookCategory->setParent($parent);

        if (isset($data['children'])) {
            foreach ($data['children'] as $child => $childData) {
                $this->persistBookCategory($bookCategory, $child, $childData, $manager);
            }
        }

        $manager->persist($bookCategory);
    }
}