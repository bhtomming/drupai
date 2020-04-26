<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/11/21
 * Time: 14:52
 * Site: http://www.drupai.com
 */

namespace App\Services;


class Page
{
    private $title;

    private $keywords;

    private $description;

    private $menu;

    private $mainContent;

    private $leftSide;

    private $rightSide;

    private $bottom;

    private $footer;

    private $contact;

    private $friendship;

    private $copyright;

    private $meta;

    private $headScript;

    private $style;

    private $bottomScript;

    private $container;

    public function __construct()
    {

    }

    public function get($name)
    {
        return $this->container->get($name);
    }

}