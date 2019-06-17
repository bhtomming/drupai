<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\9\15 0015
 * Time: 11:44
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PageMeta
 * @package App\Entity
 */
 abstract class PageMeta
{
     /**
      * @ORM\Column(type="string", length=255)
      */
    protected $slug;

     /**
      * @ORM\Column(type="string", length=255, nullable=true)
      */
    protected $keywords;

     /**
      * @ORM\Column(type="string", length=255, nullable=true)
      */
    protected $description;

     /**
      * @ORM\Column(type="integer",  nullable=true)
      */
    protected $readNum;

     /**
      * @ORM\Column(type="datetime")
      */
     protected $createdAt;

     /**
      * @ORM\Column(type="datetime")
      */
     protected $updatedAt;

    public function setSlug(?string $slug) :self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setKeywords(?string $keywords) :self
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setDescription(?string $description) :self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setReadNum(?string $readNum = null) :self
    {
        if($readNum == null ){
            $this->readNum++;
            return $this;
        }
        $this->readNum = $readNum;
        return $this;
    }

    public function getReadNum(): ?int
    {
        return $this->readNum;
    }

     public function getCreatedAt(): ?\DateTimeInterface
     {
         return $this->createdAt;
     }

     public function setCreatedAt(\DateTimeInterface $createdAt): self
     {
         $this->createdAt = $createdAt;
         if(!$this->updatedAt){
             $this->setUpdatedAt($createdAt);
         }
         return $this;
     }

     public function getUpdatedAt(): ?\DateTimeInterface
     {
         return $this->updatedAt;
     }

     public function setUpdatedAt(\DateTimeInterface $updatedAt): self
     {
         $this->updatedAt = $updatedAt;

         return $this;
     }

     public function __construct()
     {
         $this->readNum = 0;
         $this->setCreatedAt(new \DateTime('now'));
     }

 }