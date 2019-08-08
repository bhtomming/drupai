<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CityPage;
use App\Repository\ArticleRepository;


use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home",options={"sitemap":true})
     */
    public function index()
    {
        //dump($this->getUser());exit;
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/ji-ben-xin-xi/{oldLink}", name="jbxx_oldLink")
     * @Route("/wang-zhan-jian-she/{oldLink}", name="jbxx_oldLink")
     * @Route("/wang-zhan-zhi-shi/{oldLink}", name="wzzs_oldLink")
     * @Route("/sheng-huo-za-tan/{oldLink}", name="shzt_oldLink")
     * @Route("/bo-ke/{oldLink}", name="boke_oldLink")
     *
     */
    public function oldLink(Article $article){
        return $this->redirectToRoute('article_show',['slug' => $article->getSlug()],301);
    }

    /**
     * @Route("/product/", name="product_list")
     */
    public function product(){
        return $this->render('product/list.html.twig');
    }

    /**
     * @Route("/case/", name="case_list", options={"sitemap":true})
     */
    public function cases(ArticleRepository $repository){
        $articles = $repository->findByCategory(26);
        return $this->render('case/list.html.twig',['articles'=>$articles]);
    }

    /**
     * @Route("/news/",defaults={"page": "1", "_format"="html"}, name="news_list")
     * @Route("/news/pages/{page}",defaults={"_format"="html"}, requirements={"page": "[1-9]\d*"}, name="news_index_paginated")
     */
    public function news(ArticleRepository $articleRepository,int $page){
        $articles = $articleRepository->findLatest($page);
        return $this->render('news/list.html.twig',['articles'=>$articles]);
    }

    /**
     * @Route("/about_us/", name="about", options={"sitemap":true})
     */
    public function about(){
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/contact/", name="contact", options={"sitemap":true})
     */
    public function contact(){
        return $this->render('default/contact.html.twig');
    }

    /**
     * @Route("/solution/", name="solution", options={"sitemap":true})
     */
    public function solution(){
        return $this->render('solution/index.html.twig');
    }


    /**
     *  @Route("city/{slug}", name="city_page_show", methods="GET",defaults={"_format"="html"})
     *
     */
    public function cityPage(CityPage $cityPage)
    {
        $template = "";
        switch ($cityPage->getType())
        {
            case 1:
                $template = "city_app.html.twig";
                break;
            case 2:
                $template = "category.html.twig";
                break;
            case 3:
                $template = "city_category.html.twig";
                break;
            default:
                $template = "city_web.html.twig";
                break;
        }
        return $this->render('citypage/'.$template, [
            'city_page' => $cityPage,
        ]);

    }

    //保存文件,可以保存网络文件及本地文件
    public function saveFile($dom,$fileName){
        $fileControl = new Filesystem();
        $fileControl->copy($dom,$fileName);
    }

    //分析链接
    public function analysisLink($url){
        //绝对链接
        if(stripos($url,'http') || stripos($url,'https')){

        }
    }
}













