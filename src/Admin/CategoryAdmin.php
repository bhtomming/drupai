<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\12 0012
 * Time: 9:09
 * QQ: 233238526
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title',null,array(
                    'label'=> '名称'
                ))
            ->add('keywords',null,array(
                'label'=> '关键词'))
            ->add('description',TextareaType::class,array(
                'label'=> '描述'))

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title',null,array(
            'label' => '名称'
        ))
            ->add('description',null,array(
                'label' => '描述'
            ))
            ->add('readNum')
        ;
    }

}