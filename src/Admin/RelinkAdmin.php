<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RelinkAdmin extends AbstractAdmin
{
    public function configureListFields(ListMapper $list)
    {
       $list->add('id',null,[
           'label'=>'ID标签'
       ])
           ->addIdentifier('tag',null,[
               'label'=> '标签'
           ])
           ->add('link',null,[
               'label'=>'链接'
           ])
           ;
    }

    public function configureFormFields(FormMapper $form)
    {
        $form->add('tag',null,[
            'label'=>'标签'
        ])
            ->add('link',null,[
                'label'=>'链接'
            ]);
    }

}