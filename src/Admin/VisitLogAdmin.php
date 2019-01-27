<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\14 0014
 * Time: 16:55
 * QQ: 233238526
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class VisitLogAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->add('username')
            ->add('currentUrl')
            ->add('referrer')
            ->add('action')
            ->add('createdAt')
            ;
    }

}