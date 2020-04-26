<?php


namespace App\Controller;


use App\Entity\Article;
use App\Services\FileUploader;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/file")
 */
class FileController extends AbstractController
{

    /**
     * @Route("/browser",name="file_browser")
     */
    public function fileBrowser()
    {}

    /**
     * @Route("/flash", name="file_flash")
     */
    public function fileFlash(){}

    /**
     * @Route("/image/browser", name="image_browser")
     */
    public function imageBrowser(Request $request)
    {
        $page = $request->query->get('page') ? : 1;

        $uploader = $this->getUploader();
        $images = $uploader->browser();
        //dump($this->getParameter('app.path.article_images'));exit;
        $arr = new ArrayAdapter($images);
        $images = new Pagerfanta($arr);
        $images->setMaxPerPage(12)
            ->setCurrentPage($page);
        return $this->render('files/image.browser.html.twig',[
            'images' =>$images,
        ]);
    }

    /**
     * @Route("/image/browser/link", name="image_browser_link")
     */
    public function imageBrowserLink(){}

    /**
     * @Route("/upload", name="file_upload")
     */
    public function fileUpload(){}

    /**
     * @Route("/image/upload", name="image_upload")
     *
     */
    public function imageUpload(Request $request)
    {
        //获取文件
        $file = $request->files->get('upload');
        //上传文件
        $uploader = $this->getUploader();
        $fileName = $uploader->upload($file);
        //返回信息
        $data = [
            'uploaded' => true,
            'fileName' => $fileName,
            'url' =>'/'.$uploader->getTargetDirectory().'/'.$fileName,
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/flash/upload", name="file_flash_upload")
     */
    public function fileFlashUpload(Request $request){
        $data = [
            'status' => 202,
        ];
        $realPath = $this->getParameter('kernel.project_dir').'/public';
        //判断是不是AJAX请求
        if($request->isXmlHttpRequest()){
            $fileName = $realPath.$request->request->get('fileName');
            $option = $request->request->get('option');
            $data['filename'] = $fileName;
            if($option == 'del'){
                if(file_exists($fileName)){
                    unlink($fileName);
                    $data['status'] = 200;
                    $data['filename'] = $fileName;
                }
            }elseif($option == 'mod'){
                $oldFile = $realPath.$request->request->get('filePath');

                $newName = $realPath.'/'.Article::IMAGE_DIR.'/'.$request->request->get('fileName');

                if(file_exists($oldFile)){
                    $extend = substr($oldFile,strrpos($oldFile,'.'));
                    rename($oldFile,$newName.$extend);
                    $data['status'] = 200;
                }
            }
        }

        return new JsonResponse($data);
    }



    public function getUploader():? FileUploader
    {
        return  new FileUploader(Article::IMAGE_DIR);
    }
}