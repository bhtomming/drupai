<?php

namespace App\DataFixtures;

use App\Entity\CityPage;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class CategoryFixture extends Fixture
{
    private $em;

    private $cityData;

    private $pinyin;

    public function __construct(EntityManagerInterface $em,PinYin $pinyin)
    {
        $this->em = $em;
        $this->pinyin = $pinyin;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //$this->initCityData($manager);
    }

    public function initCityData(ObjectManager $manager){

        $this->cityData = json_decode(file_get_contents(__DIR__.'/../Resources/data/category.json'));


        //echo var_export($datas);

        $num = 1;
        foreach ($this->cityData as $category){
            $name = $category->name;
            $level = $category->level;

            //一级类目处理
            if($level == 1)
            {
                $cityPage = new CityPage();
                $cityPage->setType(CityPage::TAG);
                $cityPage->setMainWord($name);
                $cityPage->setSlug($this->getSlug($name));
                $cityPage->setKeywords($this->replaceKeywords($name));
                $cityPage->setDescription($this->replaceDescription($name));

                $datas2 =  array_filter($this->cityData,function($data) use ($category){
                    if($data->class1 == $category->class1 && $data->level != null){
                        return 1;
                    }
                    return 0;
                });

                foreach ($datas2 as $classes)
                {
                    if(strpos($classes->name,"国")||strpos($classes->name,"政协")||strpos($classes->name,"法院")||strpos($classes->name,"人民")||strpos($classes->name,"彩票")){
                        //echo $classes->name."\n";
                        continue;
                    }
                    $subclass = new CityPage();
                    $subclass->setType(CityPage::TAG);
                    $subclass->setSlug($this->getSlug($classes->name));
                    $subclass->setMainWord($classes->name);
                    $subclass->setKeywords($this->replaceKeywords($classes->name));
                    $subclass->setDescription($this->replaceDescription($classes->name));

                    $cityPage->addSubLink($subclass);
                    $manager->persist($subclass);

                }
                $manager->persist($cityPage);
            }
            echo "this is category ".$num."\n";
            $num++;

        }
        $manager->flush();


    }

    public function replaceKeywords($city)
    {
        return "{$city}网站制作,{$city}网站开发,{$city}网站搭建,{$city}网站营销,各行业网站营销推广助手";
    }

    public function replaceDescription($description)
    {
        return "助派网络营销推广助手为{$description}各行业中小型企业提供优质的：网站开发、建设、部署等{$description}的解决方案以及{$description}网站相关产品服务。给{$description}客户最新的互联网思维，从互联网思维到提高用户转化率，我们致力帮助解决企业网络营销问题。";
    }

    public function getSlug($word)
    {
        return $this->pinyin->getChineseChar($word."网站制作");
    }
}
