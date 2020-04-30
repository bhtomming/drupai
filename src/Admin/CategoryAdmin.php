<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\12 0012
 * Time: 9:09
 * QQ: 233238526
 */

namespace App\Admin;


use App\Entity\Category;
use App\Services\PinYin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('parent',EntityType::class,[
                'label'=>'上级分类',
                'choice_label'=>'title',
                'class'=>Category::class,
                 'placeholder'  => '选择上级分类',
                'required' => false,
            ])
            ->add('title',null,array(
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
            ->add('slug',null,array(
                'label' => '页面'
            ))
            ->add('浏览量')
        ;
    }

    public function create($object)
    {
        $pinyin = new PinYin();
        assert($object instanceof Category);
        $object->setSlug($pinyin->getChineseChar($object->getTitle()));
        return parent::create($object);
    }

}