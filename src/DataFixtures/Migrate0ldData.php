<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Migrate0ldData extends Fixture
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
        /*$host = $this->container->getParameter('host');
        $dbuser = $this->container->getParameter('user');
        $pass = $this->container->getParameter('pass');
        $dbname = $this->container->getParameter('dbname');
        $conn = new \mysqli($host,$dbuser,$pass,$dbname);
        $conn->query('set name utf8');
        $sql = "select entity_id, body_value,body_summary from drun_field_data_body";
        $bodyData = $conn->query($sql)->fetch_all();
        $user = $manager->getRepository(User::class)->find(1);
        if(!$user instanceof User){
            exit();
        }
        foreach ($bodyData as $index => $page){
            $article = new Article();
            $page[1] = str_replace('/sites/default/files/ueditor/images','/uploads/images/articles',$page[1]);
            $bodyData[$index]  = $page;
            $sql = "select nid,title,created,changed from drun_node where nid = {$bodyData[$index][0]}";
            $titles = $conn->query($sql)->fetch_row();
            $sql_alias = "select alias from drun_url_alias where source = 'node/{$page[0]}'";
            $alias = $conn->query($sql_alias)->fetch_row();
            $sql_cate = "select tid from drun_taxonomy_index where nid = {$page[0]}";

            $taxonomy = $conn->query($sql_cate)->fetch_row();
            $article->setAuthor($user);
            $article->setTitle($titles[1]);
            $article->setCreatedAt(new \DateTime(date("Y-m-d h:i:s",$titles[2])));
            $article->setUpdatedAt(new \DateTime(date("Y-m-d h:i:s",$titles[3])));

            empty($page[2]) ? $article->setSummary(substr_replace(strip_tags($page[1]),'...',140)) : $article->setSummary(substr_replace(strip_tags($page[2]),'...',140));
            $article->setContent($page[1]);
            $article->setSlug($this->pinyin->getChineseChar($article->getTitle()));
            $article->setOldLink(substr($alias[0],strrpos($alias[0],'/')+1));
            if(!$taxonomy){
                $manager->persist($article);
                continue;
            }
            $category = $manager->getRepository(Category::class)->find($taxonomy[0]);
            if($category instanceof Category){
                $article->setCategory($category);
            }


            $manager->persist($article);
        }
        $manager->flush();*/
    }


}
