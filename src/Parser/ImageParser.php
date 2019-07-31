<?php

namespace Pagevamp\Parser;


use Illuminate\Http\UploadedFile;
use Pagevamp\Parser\StorageParser;
use Pagevamp\Uploader\UploadableInterface;

class ImageParser implements UploadableInterface
{
    private $file;
    private $name;

    /**
     * ImageParser constructor.
     * @param $file name or object
     */
    public function __construct($file)
    {
        $this->file = $file;
        $this->parseFile();
        $this->name = $this->file->getClientOriginalName();
    }

    private function parseFile()
    {
        if (!$this->file instanceOf UploadedFile) {
            $this->file = new StorageParser($this->file);
        }
    }

    public function getExtension()
    {
        return $this->file->getClientOriginalExtension();
    }

    public function getMimeType()
    {
        return $this->file->getMimeType();
    }

    public function getSize()
    {
        return $this->file->getSize();
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContent()
    {
        return $this->file->get();
    }

    public function generateUniqueName(array $namesToFilter)
    {
        $name = $this->getName();
        $nameWithoutExtension = str_slug(pathinfo($name, PATHINFO_FILENAME));
        $fullImageName = str_slug($nameWithoutExtension) . '.' . $this->getExtension();
        $counter = 1;

        while (\in_array($fullImageName, $namesToFilter)) {
            $fullImageName = str_slug($nameWithoutExtension) . '-' . $counter . '.' . $this->getExtension();
            ++$counter;
        }

        $this->name = $fullImageName;
    }
}
