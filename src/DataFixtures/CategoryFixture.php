<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    private $pinyin;
    public function __construct(PinYin $pinYin)
    {
        $this->pinyin = $pinYin;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $conn = new \mysqli('127.0.0.1','root','root','drupai');
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
        file_put_contents(__DIR__.'/fixture.log.txt','存入分类信息\n',FILE_APPEND);
        $manager->flush();
    }
}
