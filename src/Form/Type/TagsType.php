<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\9\14 0014
 * Time: 17:23
 */

namespace App\Form\Type;


use App\Form\DataTransformer\TagArrayToStringTransformer;
use App\Repository\CategoryRepository;
use App\Services\PinYin;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TagsType extends AbstractType
{
    private $tags;
    private $pinyin;
    public function __construct(CategoryRepository $tags,PinYin $pinYin)
    {
        $this->tags = $tags;
        $this->pinyin = $pinYin;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CollectionToArrayTransformer(),true)
            ->addModelTransformer(new TagArrayToStringTransformer($this->tags,$this->pinyin),true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['categories'] = $this->tags->findAll();
    }

    public function getParent()
    {
        return TextType::class;
    }

}