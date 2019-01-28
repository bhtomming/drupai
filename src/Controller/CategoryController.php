<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_index", methods="GET", options={"sitemap":true})
     * @Route("/{slug}", name="category_show", methods="GET")
     */
    public function index(Category $category,Request $request): Response
    {
        $session = $request->getSession();
        $path = $request->getPathInfo();
        $this->isRead($session,$path,$category);

        $articles = $category->getArticles();
        return $this->render('category/list.html.twig', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods="GET|POST")

    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{slug}", name="category_show", methods="GET")

    public function show(Category $category): Response
    {
        $articles = $category->getArticles();
        return $this->render('news/list.html.twig', ['articles' => $articles]);
    }*/

    /**
     * @Route("/{id}/edit", name="category_edit", methods="GET|POST")

    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    } */

    /**
     * @Route("/{id}", name="category_delete", methods="DELETE")

    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
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
