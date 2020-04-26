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
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt',
    ];

    protected function configureListFields(ListMapper $list)
    {
        $list->add('username',null,['label'=>'用户'])
            ->add('currentUrl',null,['label'=>'访问'])
            ->add('userAgent',null,['label'=>'访问标头'])
            ->add('referrer',null,['label'=>'来源'])
            ->add('ip',null,['label'=>'来访IP'])
            ->add('action',null,['label'=>'方式'])
            ->add('createdAt',null,[
                'label'=>'时间',
                'format'=>'Y年m月d日 H:i:s',
                'timezone' => 'Asia/Shanghai',
                'sortable'=>true,
            ])
            ;
    }

}