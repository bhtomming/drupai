<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\12 0012
 * Time: 9:59
 * QQ: 233238526
 */

namespace App\Admin;


use App\Entity\Article;
use App\Entity\Category;
use App\Services\FileUploader;
use App\Services\PinYin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'updatedAt',
    ];

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('createImg','html',[
            'header_style' => 'width: 64px; max-height: 80px;',
            'label'=>'图片'
            ])
            ->addIdentifier('title')
            ->add('category.title')
            ->add('summary')
            ->add('readNum')
            ->add('createdAt',null,[
                'label'=>'创建时间',
                'format'=>'Y年m月d日 H:i:s',
                'timezone' => 'Asia/Shanghai',
                'sortable'=>true,
            ])
            ->add('updatedAt',null,[
                'label'=>'修改时间',
                'format'=>'Y年m月d日 H:i:s',
                'timezone' => 'Asia/Shanghai',
                'sortable'=>true,
                ])
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $article = $this->getSubject();
        $imageOption = ['required'=>false];
        if($article && $imgPath =  $article->getTitleImg()){
            $imageOption['help'] = '<img src="'.$imgPath.'" class="admin-preview" />';
        }
        $form->add('title')
            ->add('image',FileType::class,$imageOption)
            ->add('summary')
            ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('content',CKEditorType::class,array(
                'config' => []
            ))
        ;
    }

    public function configureBatchActions($actions)
    {
        $actions['publish'] =[
            'ask_confirmation' => true,
            'label'=>'发布文章',
        ];

        return $actions;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title')
            ->add('category',null,[],EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function create($object)
    {
        $pinyin = new PinYin();
        assert($object instanceof Article);
        $object->setSlug($pinyin->getChineseChar($object->getTitle()));

        return parent::create($object);
    }

    public function toString($object)
    {
        return $object instanceof Article
            ? $object->getTitle()
            : 'Article'; // shown in the breadcrumb on the create view
    }

    public function prePersist($article)
    {
        $this->manageFileUpload($article);
    }

    public function preUpdate($article)
    {
        $this->manageFileUpload($article);
    }


    //上传图片处理
    private function manageFileUpload($article)
    {
        if ($article->getImage() instanceof UploadedFile) {
            $loader = new FileUploader(Article::IMAGE_DIR);
            $fileName = $loader->upload($article->getImage());
            $article->setTitleImg('/'.Article::IMAGE_DIR.'/'.$fileName);
            $article->setUpdatedAt(new \DateTime('now'));
        }
    }


}