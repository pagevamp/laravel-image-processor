<?php

namespace Pagevamp;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Pagevamp\Resizer\Resizer;
use Pagevamp\Uploader\Uploader;
use Pagevamp\Parser\ImageParser;

class Processor
{
    private $parser;
    private $resizer;
    private $uploader;
    private $uploadPath;

    public function __construct($file)
    {
        $this->parser = new ImageParser($file);
    }

    public function resize($sizes)
    {
        $this->resizer = (new Resizer($this->parser, app(ImageManager::class), $sizes))->resize();

        return $this->resizer;
    }

    public function uploadOriginalImage($path = false)
    {
        $this->uploader = (new Uploader($this->parser, app(Storage::class), $path))->upload();

        return $this->uploader;
    }

    public function generateUniqueName($namesToFilter)
    {
        return $this->parser->generateUniqueName($namesToFilter);
    }

    public function setName($name)
    {
        return $this->parser->setName($name);
    }

    public function getImageInfo()
    {
        return $this->parser;
    }

}
