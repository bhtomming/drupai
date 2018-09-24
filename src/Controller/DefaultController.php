<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
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
     * @Route("/case/", name="case_list")
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
     * @Route("/contact/", name="contact")
     */
    public function contact(){
        return $this->render('default/contact.html.twig');
    }
}
