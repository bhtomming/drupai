<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends PageMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;


    public function __construct()
    {
        parent::__construct();
        $this->articles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    public function __toString() :string
    {
        return $this->title ? $this->title : 'Category';
    }

    public function addArticle(Article $article)
    {
        if(!$this->articles->contains($article)){
            $this->articles->add($article);
        }
        return $this;
    }

    public function removeArticle(Article $article)
    {
        if($this->articles->contains($article)){
            $this->articles->remove($article);
        }
        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }


}
