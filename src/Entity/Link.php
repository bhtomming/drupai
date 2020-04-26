<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Link
 * @package App\Entity
 */
abstract class Link
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;

}