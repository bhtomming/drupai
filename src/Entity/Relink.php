<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelinkRepository")
 */
class Relink
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
    private $tag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
