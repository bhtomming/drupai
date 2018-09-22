<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\9\14 0014
 * Time: 17:01
 */

namespace App\Form\DataTransformer;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Services\PinYin;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagArrayToStringTransformer implements DataTransformerInterface
{
    private $tag;
    private $pinYin;

    public function __construct(CategoryRepository $tag,PinYin $pinYin)
    {
        $this->tag = $tag;
        $this->pinYin = $pinYin;
    }

    //取出数据
    public function transform($tag) :string
    {
        return implode(',',$tag);
    }

    //存入数据
    public function reverseTransform($string) :array
    {
        if(''=== $string || null === $string){
            return [];
        }
        $names = array_filter(array_unique(array_map('strtoupper',array_map('trim',explode(',',$string)))));
        $tags = $this->tag->findBy([
            'title'=>$names,
        ]);
        $newnames = array_diff($names,array_map('strtoupper',$tags));
        foreach ($newnames as $name){
            $tag = new Category();
            $tag->setTitle($name);
            $tag->setSlug($this->pinYin->getChineseChar($name));
            $tag->setCreatedAt(new \DateTime('now'));
            $tags[] = $tag;
        }
        return $tags;

    }
}