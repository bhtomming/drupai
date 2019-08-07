<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/6/17
 * Time: 20:29
 * Site: http://www.drupai.com
 */

namespace App\DataFixtures;


use App\Entity\CityPage;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

class AppPageFixture extends Fixture
{
    private $em;

    private $num;

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

        $this->cityData = json_decode(file_get_contents(__DIR__.'/../Resources/data/city/citylist.json'),true);//加参数得到数组

        $currentProvinceCode = '';
        $currentCityCode = '';
        $province = '';
        $city = '';
        foreach ($this->cityData as $code => $name){

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


            echo "this is app ".$this->num."\n";

            $this->num++;
            $manager->flush();
        }

    }

    public function replaceKeywords($city)
    {
        return "{$city}小程序制作,{$city}小程序开发,{$city}小程序商城,{$city}微信小程序开发,小程序,营销推广助手";
    }

    public function replaceDescription($description)
    {
        return "助派网络营销推广助手为{$description}中小型企业提供优质的：小程序开发、建设、部署等{$description}的解决方案以及{$description}微信小程序相关产品服务。给{$description}客户最新的互联网思维，从互联网思维到提高用户转化率，我们致力帮助解决企业营销方案。";
    }

    public function getSlug($word)
    {
        return $this->pinyin->getChineseChar($word."小程序");
    }

    public function createCity($name,$manager)
    {
        $xCity = new CityPage();
        $xCity->setType(CityPage::APP);
        $xCity->setMainWord($name);
        $xCity->setSlug($this->getSlug($name));
        $xCity->setKeywords($this->replaceKeywords($name));
        $xCity->setDescription($this->replaceDescription($name));
        $manager->persist($xCity);
        return $xCity;
    }



}