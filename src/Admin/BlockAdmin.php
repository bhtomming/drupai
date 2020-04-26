<?php


namespace App\Admin;


use App\Entity\Region;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BlockAdmin extends AbstractAdmin
{

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name',null,[
            'label' => '名称'
        ])
            ->add('path',null,[
                'label' => '路径'
            ])
            ->add('region',null,[
                'label'=>'区域'
            ])
            ;
    }

    public function configureFormFields(FormMapper $form)
    {
        $form->add('name',null,[
            'label'=>'名称'
        ])
            ->add('path',null,[
                'label'=>'指定路径'
            ])
            ->add('region',EntityType::class,[
                'choice_label'=>'name',
                'class'=>Region::class,
                'label'=>'指定区域',
                'placeholder'=>'请选择指定区域',
                'choice_value'=>'id'
            ])
            ->add('enable',null,[
                'label'=>'是否启用'
            ])
            ->add('codes',CKEditorType::class,[
                'label'=>'自定义代码',
                'config' => []
            ])
            ;
    }

}