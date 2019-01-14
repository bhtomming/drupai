<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 *
 */
class Article extends PageMeta
{
    public const NUM_ITEMS = 25;
    const IMAGE_DIR = "uploads/articles/images";

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleImg;

    private $image;


    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $oldLink;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", cascade={"persist"},inversedBy="articles")
     */
    private $category;


    public function __construct()
    {
        parent::__construct();
        $this->setCreatedAt(new \DateTime('now'));
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'Article';
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setImage(UploadedFile $file = null){
        $this->image = $file;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(){
        return $this->image;
    }

    public function createImg(){
        return "<img src='{$this->titleImg}' />";
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getTitleImg(): ?string
    {
        return $this->titleImg;
    }

    public function setTitleImg(?string $titleImg): self
    {
        $this->titleImg = $titleImg;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }





    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getOldLink(): ?string
    {
        return $this->oldLink;
    }

    public function setOldLink(string $oldLink): self
    {
        $this->oldLink = $oldLink;

        return $this;
    }



    public function getCategory()
    {
        return $this->category;
    }


    public function setCategory(Category $category): self
    {
        $category->addArticle($this);
        $this->category = $category;

        return $this;
    }
}
