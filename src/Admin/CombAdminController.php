<?php
/**
 * Created by PhpStorm.
 * User: 烽行天下
 * Date: 2019/6/6
 * Time: 19:20
 * Site: http://www.drupai.com
 */

namespace App\Admin;


use App\Entity\AbstractArticle;

use App\Entity\CombArticle;
use App\Services\CombServer;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CombAdminController extends CRUDController
{
    /**
     * @var CombServer
     */
    private $comboServer;


    public function preCreate(Request $request, $object)
    {
        if($object instanceof CombArticle)
        {
            $object->setAuthor($this->getUser());
        }
    }

    public function batchActionCombo(ProxyQueryInterface $proxyQuery, Request $request = null)
    {
        $modelManager = $this->admin->getModelManager();
        $selectIds = $request->get('idx');



        if(empty($selectIds))
        {
            $this->addFlash('sonata_flash_info','你没有选择要修改的信息');

            return new RedirectResponse($this->admin->generateUrl('list',[
                'filter' => $this->admin->getFilterParameters()
            ]));

        }
        $selectModels = $proxyQuery->execute();

        $this->comboServer = $this->container->get("app.comb_server");
        try{
            foreach ($selectModels as $selectModel)
            {
                assert($selectModel instanceof CombArticle);
                $this->comboServer->combArticle($selectModel);
                //$selectModel->getTitle();
                //$selectModel->setViewed(random_int(100,99999));
                //$modelManager->update($selectModel);
            }
        }catch (\Exception $e){
            $this->addFlash('sonata_flash_error','组合出错'.$e->getMessage());

            return new RedirectResponse($this->admin->generateUrl('list',[
                'filter' => $this->admin->getFilterParameters()
            ]));
        }

        $this->addFlash('sonata_flash_success','组合成功');

        return new RedirectResponse($this->admin->generateUrl('list',[
            'filter' => $this->admin->getFilterParameters()
        ]));
    }

}