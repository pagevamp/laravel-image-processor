<?php

namespace Pagevamp\Uploader;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Uploader
{
    private $file;
    private $finalDestination;
    private $fullImagePath;
    private $storage;

    public function __construct(UploadableInterface $file, Storage $storage, $finalPath)
    {
        $this->file = $file;
        $this->finalDestination = $finalPath;
        $this->storage = $storage::disk(Config::get('storage.driver.media'));
    }

    public function upload()
    {
        $this->fullImagePath = $this->finalDestination . '/' . $this->file->getName();
        $this->storage->put($this->fullImagePath, $this->file->getContent());
        return $this;
    }


    public function getUploadedfileUrl()
    {
        return $this->storage->url($this->fullImagePath);
    }

    public function getAbsolutePath()
    {
        return $this->storage->url($this->fullImagePath);
    }

    public function getRelativePath()
    {
        return $this->fullImagePath;
    }


}
