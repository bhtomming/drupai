<?php


namespace App\Services;


use App\Entity\Article;
use App\Entity\City;
use App\Entity\CombArticle;
use Doctrine\ORM\EntityManagerInterface;

class CombServer
{
    private $em;

    private $type;

    private $slugServer;

    public function __construct(EntityManagerInterface $manager,PinYin $slugServer)
    {
        $this->em = $manager;
        $this->slugServer = $slugServer;
    }

    public function combArticle(CombArticle $article)
    {
        $this->type = $article->getCategory()->getTitle();
        $cities = $this->em->getRepository(City::class)->findAll();
        $title = $this->combType($article->getTitle());
        $summary = $this->combType($article->getSummary());
        $content = $this->combType($article->getContent());
        $keyword = $this->combType($article->getKeywords());
        $description = $this->combType($article->getDescription());
        $author = $article->getAuthor();
        $category = $article->getCategory();
        if(strpos($title,"{地区}") > 0){
            foreach ($cities as $city){
                $name = $city->getName();
                $newArticle = new Article();
                $newTitle = $this->combCity($name,$title);
                $newArticle->setTitle($newTitle);
                $newArticle->setSummary($this->combCity($name,$summary));
                $newArticle->setContent($this->combCity($name,$content));
                $newArticle->setKeywords($this->combCity($name,$keyword));
                $newArticle->setDescription($this->combCity($name,$description));
                $newArticle->setAuthor($author);
                $newArticle->setCategory($category);
                $now = time();
                $datetime = new \DateTime(date('Y-m-d H:i:s',mt_rand($now - 15552000, $now)));
                $newArticle->setCreatedAt($datetime);
                $newArticle->setUpdatedAt($datetime);
                $newArticle->setSlug($this->slugServer->getChineseChar($newTitle));
                $this->em->persist($newArticle);
            }
        }

        $this->em->flush();
    }

    public function combCity($repStr,$oStr)
    {
        return str_replace("{地区}",$repStr,$oStr);
    }

    public function combType($str)
    {
        return str_replace("{类型}",$this->type,$str);
    }

}