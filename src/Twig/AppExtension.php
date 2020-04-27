<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/12/9
 * Time: 21:16
 * Site: http://www.drupai.com
 */

namespace App\Twig;





use App\Entity\FriendLink;
use App\Entity\Meta;
use App\Entity\Region;
use App\Entity\ReleLink;
use App\Entity\Relink;
use App\Entity\Scripts;
use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension  extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(ContainerInterface $container,UrlGeneratorInterface $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sortBy',[$this,'sortBy']),
            new TwigFilter('from_cate',[$this,'fromCate']),
            new TwigFilter('relink',[$this,'relink']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction("friendLinks",[$this,"friendLinks"]),
            new TwigFunction("site",[$this,"site"]),
            new TwigFunction("getMeta",[$this,"getMeta"]),
            new TwigFunction("getScripts",[$this,"getScripts"]),
            new TwigFunction("releLinks",[$this,"releLinks"]),
            new TwigFunction("region",[$this,"getRegion"],['is_safe'=>['html'],'needs_environment'=>true]),

        ];
    }

    public function relink($article)
    {
        $em = $this->getManager();
        $relinks = $em->getRepository(Relink::class)->findAll();

        if(!empty($relinks)){

            foreach ($relinks as $relink)
            {
                $tag = $relink->getTag();
                $str = "<a href='{$relink->getLink()}' >{$tag}</a>";
                $article = str_replace($tag,$str,$article);
            }
        }
        return $article;
    }

    public function getRegion(Environment $twig,$name)
    {
        //取出这个名称的区域
        $region = $this->getManager()->getRepository(Region::class)->findOneBy(['machineName'=>$name]);

        if (!$region instanceof Region)
        {
            return null;
        }
        //取出所有在这个区域的区块
        $blocks = $region->getBlocks();
        $html = '';
        foreach ($blocks as $block)
        {
            if($block->getEnable()){
                //把所有区块代码输出
                $html .= $block->getCodes();
            }
        }
        //返回当前区域所有区块的代码
        return $html;
    }

    public function fromCate($ob,$cate)
    {
        return array_filter($ob,function($article) use($cate){
            $category = $article->getCategory();
            if(strpos($category,$cate)>0){
                return $article;
            }
        });
    }


    public function sortBy($arr,$order,$property)
    {
        $getter = "get".ucfirst($property);

        if(strtolower($order) == "desc")
        {
            foreach ($arr as $index =>$ob)
            {
                $length = count($arr);
                for($i = 0; $i< $length - 1 - $index; $i++)
                {
                    $next = $i + 1;
                    if($arr[$i]->$getter() < $arr[$next]->$getter())
                    {
                        $tmp = $arr[$i];
                        $arr[$i] = $arr[$next];
                        $arr[$next] = $tmp;
                    }
                }

            }
        }
        return $arr;
    }

    public function site()
    {
        $sites =  $this->getManager()->getRepository(Settings::class)->findAll();
        if(empty($sites))
        {
            return new Settings();
        }
        return end($sites);
    }

    public function friendLinks()
    {
        $em = $this->getManager();
        $links = $em->getRepository(FriendLink::class)->findBy(['enable'=>true]);
        return $links;
    }

    public function releLinks()
    {
        $em = $this->getManager();
        $links = $em->getRepository(ReleLink::class)->findBy(['enable'=>true]);
        return $links;
    }

    public function getManager(): EntityManagerInterface
    {
        return $this->container->get("doctrine")->getManager();
    }


    public function getMeta()
    {
        $em = $this->getManager();
        $metas = $em->getRepository(Meta::class)->findBy(["enable"=>true]);
        return $metas;
    }

    public function getScripts()
    {
        return $this->getManager()->getRepository(Scripts::class)->findBy(['enable'=>true]);
    }


}