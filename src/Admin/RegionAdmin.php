<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegionAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('machineName',null,array(
            'label'=> '机器名称'
        ))
            ->add('name',null,array(
                'label'=> '名称'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name',null,array(
            'label' => '名称'
        ))
            ->add('machine_name',null,array(
                'label' => '描述'
            ))
        ;
    }

}