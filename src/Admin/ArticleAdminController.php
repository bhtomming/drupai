<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/6/6
 * Time: 19:20
 * Site: http://www.drupai.com
 */

namespace App\Admin;


use App\Entity\Article;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends CRUDController
{
    public function preCreate(Request $request, $object)
    {
        assert($object instanceof Article);

        $object->setAuthor($this->getUser());
    }




}