<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ReleLinkAdmin extends AbstractAdmin
{
    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add("name",null,[
                'label'=> '名称'
            ])
            ->add("url",null,[
                'label' => '链接'
            ])
        ;
    }

    public function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier("name",null,[
                'label'=> '名称'
            ])
            ->add("url",null,[
                'label' => '链接'
            ])
        ;
    }

}