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
use function PHPSTORM_META\type;
use Symfony\Component\Finder\Finder;

class CityPageFixture extends Fixture
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

            echo "this is city ".$this->num."\n";
            $this->num++;
            $manager->flush();
        }


    }

    public function replaceKeywords($city)
    {
        return "{$city}网站建设,{$city}网站制作,{$city}网站开发,{$city}做网站,网站制作,{$city}网站制作公司,营销推广助手";
    }

    public function replaceDescription($description)
    {
        return "助派网络营销推广助手为{$description}中小型企业提供优质的：网站设计、开发、建设、上线等{$description}的解决方案以及{$description}电子商务相关产品服务。能给{$description}客户最新的互联网理念，从网站结构的规划UI设计到用户体验提高，我们力求做到极致完美";
    }

    public function getSlug($word)
    {
        return $this->pinyin->getChineseChar($word);
    }

    public function createCity($name,$manager)
    {
        $xCity = new CityPage();
        $xCity->setType(CityPage::WEB);
        $xCity->setMainWord($name);
        $xCity->setSlug($this->getSlug($name));
        $xCity->setKeywords($this->replaceKeywords($name));
        $xCity->setDescription($this->replaceDescription($name));
        $manager->persist($xCity);
        return $xCity;
    }


}