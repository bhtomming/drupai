<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/6/17
 * Time: 20:29
 * Site: http://www.drupai.com
 */

namespace App\DataFixtures;


use App\Entity\City;
use App\Services\PinYin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use function PHPSTORM_META\type;
use Symfony\Component\Finder\Finder;

class CityFixture extends Fixture
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
        $this->initCityData($manager);
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
                $province = $this->createCity($name,$code,$manager);
                echo "\n录入省：".$name;
                continue;

            }
            if(substr($code,0,2)== substr($currentProvinceCode,0,2)&& substr($code,4) == 00)
            {   //同一省的城市
                $currentCityCode = $code;
                $city = $this->createCity($name,$code,$manager);
                $province->addChildren($city);
                $this->addBrother($province,$city);
                $manager->persist($province);
                echo "\n录入市：".$name;
                continue;
            }
            if(substr($code,0,4) == substr($currentCityCode,0,4))
            {   //同一城市的区域
                $eare = $this->createCity($name,$code,$manager);
                $city->addChildren($eare);
                $this->addBrother($city,$eare);
                echo "\n录入区：".$name;
                $manager->persist($city);
            }else{
                $province->addChildren($this->createCity($name,$code,$manager));
                $manager->persist($province);
                echo "\n录入直辖市：".$name;
            }

            echo "\nthis is city ".$this->num."\n";
            $this->num++;
            $manager->flush();
        }


    }


    public function getSlug($word)
    {
        return $this->pinyin->getChineseChar($word);
    }

    public function createCity($name,$code,$manager)
    {
        $city = new City();
        $city->setCode($code);
        $city->setName($name);
        $manager->persist($city);
        return $city;
    }

    public function addBrother(City $parent,City $city)
    {
        foreach ($parent->getChildren() as $child)
        {
            if($child != $city && $child != null)
            {
                $city->addBrother($child);
            }
        }
        return $city;
    }


}