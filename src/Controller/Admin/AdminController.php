<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\9\15 0015
 * Time: 9:01
 */

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdmin;


class AdminController extends BaseAdmin
{
    public function updateEntity($entity)
    {
        $class = get_class($entity);
        $methods = get_class_methods($class);
        if(in_array('setUpdatedAt',$methods))
        {
            $entity->setUpdatedAt(new \DateTime('now'));
        }
        return parent::updateEntity($entity);
    }

}