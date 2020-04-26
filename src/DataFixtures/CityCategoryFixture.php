<?php

namespace App\DataFixtures;

use App\Entity\CityPage;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class CityCategoryFixture extends Fixture
{
    private $em;

    private $cityData;

    private $pinyin;

    private $classData;

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
        /*$this->cityData = json_decode(file_get_contents(__DIR__.'/../Resources/data/city/citylist.json'));
        $this->classData = json_decode(file_get_contents(__DIR__.'/../Resources/data/category.json'));
        $this->initCityData($manager);*/
    }

    public function initCityData(ObjectManager $manager){


        $currentProvinceCode = '';
        $currentCityCode = '';
        $province = '';
        $city = '';
        $num = 0;
        foreach ($this->cityData as $code => $name){
            if(substr($code,4) != 00){
                if($num<25){
                    echo "已经添加".$name."\n";
                }
                echo "当前城市是：".$name."，不是直辖市，也不是省会\n";
                $num++;
                if(end($this->cityData) == $name){
                    $manager->flush();
                }
                continue;
            }

            //省、直辖市级别的处理方式
            if(substr($code,2) == 0000)
            {
                $currentProvinceCode = $code;
                $province = $this->createCity($name,$manager);
                continue;

            }
            if(substr($code,0,2)== substr($currentProvinceCode,0,2)&& substr($code,4) == 00)
            {   //同一省的城市
                $currentCityCode = $code;
                $city = $this->createCity($name,$manager);
                $province->addSubLink($city);
                $manager->persist($province);
                continue;
            }
            if(substr($code,0,4) == substr($currentCityCode,0,4))
            {   //同一城市的区域
                $city->addSubLink($this->createCity($name,$manager));
                $manager->persist($city);
            }else{
                $province->addSubLink($this->createCity($name,$manager));
                $manager->persist($province);
            }
            $manager->flush();
        }

    }

    public function addCategory(CityPage $cityPage, ObjectManager $manager)
    {
        $city = $cityPage->getMainWord();
        $nu = 1;



        foreach ($this->classData as $category) {
            $name = $category->name;
            $level = $category->level;
            //一级类目处理
            if ($level == 1) {
                $class1 = new CityPage();
                $class1->setType(CityPage::CITY_TAG);
                $class1->setMainWord($city.$name);
                $class1->setSlug($this->getSlug($city.$name));
                $class1->setKeywords($this->replaceKeywords($city.$name));
                $class1->setDescription($this->replaceDescription($city.$name));

                $datas2 = array_filter($this->classData, function ($data) use ($category) {
                    if ($data->class1 == $category->class1) {
                        return 1;
                    }
                    return 0;
                });

                foreach ($datas2 as $classes) {
                    if (strpos($classes->name, "国") || strpos($classes->name, "政协") || strpos($classes->name, "法院") || strpos($classes->name, "人民") || strpos($classes->name, "彩票")) {
                        //echo $classes->name . "\n";
                        continue;
                    }
                    $subclass = new CityPage();
                    $subclass->setType(CityPage::CITY_TAG);
                    $subclass->setSlug($this->getSlug($city.$classes->name));
                    $subclass->setMainWord($city.$classes->name);
                    $subclass->setKeywords($this->replaceKeywords($city.$classes->name));
                    $subclass->setDescription($this->replaceDescription($city.$classes->name));

                    $class1->addSubLink($subclass);
                    $manager->persist($subclass);

                }
                $manager->persist($class1);

                $cityPage->addSubLink($class1);
            }
            echo "this is the ".$city." city, city_category ".$nu++."\n";

        }
        return $cityPage;
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

    public function createCity($name,$manager)
    {
        $xCity = new CityPage();
        $xCity->setType(CityPage::CITY_TAG);
        $xCity->setMainWord($name);
        $xCity->setSlug($this->getSlug($name));
        $xCity->setKeywords($this->replaceKeywords($name));
        $xCity->setDescription($this->replaceDescription($name));
        $xCity = $this->addCategory($xCity, $manager);
        $manager->persist($xCity);
        return $xCity;
    }
}
