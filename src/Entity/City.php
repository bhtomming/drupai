<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\City", mappedBy="parent")
     * @ORM\Column( nullable=true)
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City",inversedBy="children")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\City")
     */
    private $brother;

    public function __construct()
    {
        $this->brother = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getBrother(): ?ArrayCollection
    {
        return $this->brother;
    }

    public function addBrother(?City $city): self
    {
        if(!$this->brother->contains($city)){
            $this->brother->add($city);
            $city->addBrother($this);
        }
        return $this;
    }

    public function removeBrother(?City $brother): self
    {
        if($this->brother->contains($brother)){
            $this->brother->remove($brother);
            $brother->removeBrother($this);
        }

        return $this;
    }

    public function getChildren(): ?ArrayCollection
    {
        return $this->children;
    }

    public function addChildren(?City $children): self
    {
        if(!$this->children->contains($children)){
            $this->children->add($children);
            $children->setParent($this);
        }

        return $this;
    }

    public function removeChildren(?City $children): self
    {
        if($this->children->contains($children)){
            $this->children->remove($children);
            $children->setParent(null);
        }
        return $this;
    }

    public function getParent(): ?City
    {
        return $this->parent;
    }

    public function setParent(?City $parent): self
    {
        $parent->addChildren($this);

        $this->parent = $parent;

        return $this;
    }
}
