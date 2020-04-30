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
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     */
    private $children;




    public function __construct()
    {
        parent::__construct();
        //$this->articles = new ArrayCollection();
        $this->children = new ArrayCollection();
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

   /* public function addArticle(AbstractArticle $article)
    {
        if(!$this->articles->contains($article)){
            $this->articles->add($article);
        }
        return $this;
    }

    public function removeArticle(AbstractArticle $article)
    {
        if($this->articles->contains($article)){
            $this->articles->remove($article);
        }
        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }*/

   public function getParent(): ?self
   {
       return $this->parent;
   }

   public function setParent(?self $parent): self
   {
       if($parent != null && $parent instanceof Category)
       {
           //$parent->addChild($this);
           $this->parent = $parent;
       }

       return $this;
   }

   /**
    * @return Collection|self[]
    */
   public function getChildren(): Collection
   {
       return $this->children;
   }

   public function addChild(self $child): self
   {
       if (!$this->children->contains($child)) {
           $this->children[] = $child;

           $child->setParent($this);

       }

       return $this;
   }

   public function removeChild(self $child): self
   {
       if ($this->children->contains($child)) {
           $this->children->removeElement($child);
           // set the owning side to null (unless already changed)
           if ($child->getParent() === $this) {
               $child->setParent(null);
           }
       }

       return $this;
   }


}
