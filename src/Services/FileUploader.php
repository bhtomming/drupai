<?php
/**
 * Author: 烽行天下
 * Date: 2019\1\14 0014
 * Time: 10:43
 * QQ: 233238526
 */

namespace App\Services;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            throw new FileException(printf("不能上传文件,错误信息:%s",$e->getMessage()));
        }

        return $fileName;
    }

    public function browser()
    {
        $finder = new Finder();
        $finder->in($this->getTargetDirectory());
        $finder->name(['*.jpg','*.jpeg','*.png','*.bmp']);
        $images = [];
        foreach ($finder as $file)
        {
            $image['name'] = $file->getFilename();
            $image['url'] = '/'.$file->getPath().'/'.$file->getFilename();
            $images[] = $image;
        }
        return $images;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}