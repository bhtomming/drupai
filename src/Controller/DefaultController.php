<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="default")
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
}
