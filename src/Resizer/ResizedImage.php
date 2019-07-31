<?php

namespace Pagevamp\Resizer;


use Illuminate\Support\Facades\Storage;
use Pagevamp\Uploader\UploadableInterface;
use Pagevamp\Uploader\Uploader;

class ResizedImage implements UploadableInterface
{
    private $resizedImage;
    private $originalImage;
    private $uploader;
    private $sizeName;
    private $sizeRatio;
    private $name;
    private $uploadPath;

    public function __construct($originalImage, $resizedImage, $sizeName, $sizeRatio)
    {
        $this->sizeName = $sizeName;
        $this->originalImage = $originalImage;
        $this->resizedImage = $resizedImage;
        $this->name = $this->originalImage->getName();
        $this->uploadPath = $sizeName;
        $this->sizeRatio = $sizeRatio;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSizeName()
    {
        return $this->sizeName;
    }

    public function getSizeRatio()
    {
        return $this->sizeRatio;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getContent()
    {
        return $this->resizedImage->stream();
    }

    public function getPath()
    {
        return $this->uploadPath;
    }

    public function upload(): Uploader
    {
        $this->uploader = (new Uploader($this, app(Storage::class), $this->getPath()))->upload();

        return $this->uploader;

    }

    public function getUploadedfileUrl()
    {
        return $this->uploader->getUploadedfileUrl();
    }

    public function getRelativePath()
    {
        return $this->uploader->getRelativePath();
    }
}
