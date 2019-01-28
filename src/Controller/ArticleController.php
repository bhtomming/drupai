<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_index", methods="GET")
     *
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', ['articles' => $articleRepository->findAll()]);
    }

    /**
     * @Route("/new", name="article_new", methods="GET|POST")

    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{slug}", name="article_show", methods="GET")
     *
     */
    public function show(Article $article, Request $request): Response
    {
        $session = $request->getSession();
        $path = $request->getPathInfo();
        $this->isRead($session,$path,$article);
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods="GET|POST")

    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setSlug($this->get('app.pinyin')->getChineseChar($article->getTitle()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{id}", name="article_delete", methods="DELETE")

    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }*/

    public function isRead(SessionInterface $session, $path, $page){
        $em = $this->getDoctrine()->getManager();
        if(!$session->has('read')){
            //从来没有过会话，添加会话信息，文章阅读量加1
            $page->setReadNum();
            $session->set('read',array($path));
        }
        if($session->has('read') && !in_array($path,$session->get('read'))){
            $readLog = $session->get('read');
            if(!in_array($path,$readLog)){
                //本次会话没有阅读过,文章阅读量加1
                $page->setReadNum();
                $readLog[] = $path;
                $session->set('read',$readLog);
            }
        }
        $em->persist($page);
        $em->flush();
    }
}
