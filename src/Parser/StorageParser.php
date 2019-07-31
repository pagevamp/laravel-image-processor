<?php

namespace Pagevamp\Parser;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class StorageParser
{
    private $storage;
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;

//        $this->storage = app(Storage::class);
        $this->storage = Storage::disk(Config::get('storage.driver.media'));

    }

    public function getClientOriginalName()
    {
        return basename($this->fileName);
    }

    public function getNameWithoutExtension()
    {
        return pathinfo($this->fileName, PATHINFO_FILENAME);
    }

    public function getClientOriginalExtension()
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    public function getMimeType()
    {
        return $this->storage->getMimeType($this->fileName);
    }

    public function get()
    {
        return $this->storage->get($this->fileName);
    }

    public function getSize()
    {
        return $this->storage->size($this->fileName);
    }
}
