<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityPageRepository")
 */
class CityPage extends PageMeta
{
    const WEB = 0;
    const APP = 1;
    const TAG = 2;
    const CITY_TAG = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mainWord;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CityPage", mappedBy="parentPage")
     */
    private $subLinks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CityPage",inversedBy="subLinks")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parentPage;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;


    public function __construct()
    {
        parent::__construct();
        $this->subLinks = new ArrayCollection();
        $now = time();
        $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s',mt_rand($now - 15552000, $now))));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMainWord(): ?string
    {
        return $this->mainWord;
    }

    public function setMainWord(string $mainWord): self
    {
        $this->mainWord = $mainWord;

        return $this;
    }

    /**
     * @return Collection|CityPage[]
     */
    public function getSubLinks(): Collection
    {
        return $this->subLinks;
    }

    public function addSubLink(CityPage $subLink): self
    {
        if (!$this->subLinks->contains($subLink)) {
            $this->subLinks[] = $subLink;
            $subLink->setParentPage($this);
        }

        return $this;
    }

    public function removeSubLink(CityPage $subLink): self
    {
        if ($this->subLinks->contains($subLink)) {
            $this->subLinks->removeElement($subLink);
            // set the owning side to null (unless already changed)
            if ($subLink->getParentPage() === $this) {
                $subLink->setParentPage(null);
            }
        }

        return $this;
    }

    public function setParentPage(?CityPage $parentPage): self
    {
        $this->parentPage = $parentPage;

        return $this;
    }

    public function getParentPage(): ?CityPage
    {
        return $this->parentPage;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }



}
