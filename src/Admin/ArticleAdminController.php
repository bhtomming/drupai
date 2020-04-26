<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/6/6
 * Time: 19:20
 * Site: http://www.drupai.com
 */

namespace App\Admin;


use App\Entity\Article;
use App\Entity\CombArticle;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends CRUDController
{
    public function preCreate(Request $request, $object)
    {
        if($object instanceof Article)
        {
            $object->setAuthor($this->getUser());
        }
    }

    public function batchActionPublish(ProxyQueryInterface $proxyQuery, Request $request)
    {
        $modelManager = $this->admin->getModelManager();
        $selectIds = $request->get('idx');

        if(empty($selectIds))
        {
            $this->addFlash('sonata_flash_info','你没有选择要发布的信息');

            return new RedirectResponse($this->admin->generateUrl('list',[
                'filter' => $this->admin->getFilterParameters()
            ]));

        }
        $selectModels = $proxyQuery->execute();

        $em = $this->getDoctrine()->getManager();
        try{
            foreach ($selectModels as $selectModel)
            {
                assert($selectModel instanceof Article);
                $selectModel->setPublished(true);
                $selectModel->setUpdatedAt(new \DateTime('now'));
                $em->persist($selectModel);
            }
            $em->flush();
        }catch (\Exception $e){
            $this->addFlash('sonata_flash_error','发布出错'.$e->getMessage());

            return new RedirectResponse($this->admin->generateUrl('list',[
                'filter' => $this->admin->getFilterParameters()
            ]));
        }

        $this->addFlash('sonata_flash_success','发布成功');

        return new RedirectResponse($this->admin->generateUrl('list',[
            'filter' => $this->admin->getFilterParameters()
        ]));
    }


}