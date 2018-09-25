<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CategoryFixture extends Fixture
{
    private $pinyin;
    private $container;
    public function __construct(PinYin $pinYin, ContainerInterface $container)
    {
        $this->pinyin = $pinYin;
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $host = $this->container->getParameter('host');
        $dbuser = $this->container->getParameter('user');
        $pass = $this->container->getParameter('pass');
        $dbname = $this->container->getParameter('dbname');
        $conn = new \mysqli($host,$dbuser,$pass,$dbname);
        $conn->query('set name utf8');
        $sql = "select name, description from drun_taxonomy_term_data";
        $taxonomies = $bodyData = $conn->query($sql)->fetch_all();
        foreach ($taxonomies as $index => $taxonomy){
            $category = new Category();
            $category->setTitle($taxonomy[0]);
            $category->setDescription($taxonomy[1]);
            $category->setSlug($this->pinyin->getChineseChar($taxonomy[0]));
            $category->setCreatedAt(new \DateTime('now'));
            $manager->persist($category);

        }

        $manager->flush();
    }
}
