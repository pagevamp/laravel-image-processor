<?php

namespace Pagevamp\Tests\Unit\Parser;

use Illuminate\Container\Container;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase;
use Pagevamp\Parser\ImageParser;
use \Pagevamp\Tests\AbstractTestCase;
use Tests\CreatesApplication;


class ImageParserTest extends AbstractTestCase
{


    public function testIfImageDetailsAreCorrectAfterUpload()
    {

        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');
        $imageParser = new ImageParser($uploadedFile);

        $this->assertSame($imageParser->getName(),'avatar.jpg');
        $this->assertSame($imageParser->getExtension(),'jpg');
        $this->assertSame($imageParser->getMimeType(),'image/jpeg');
    }

    public function testIfIUniqueNameIsGenerateAfterUpload()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');
        $imageParser = new ImageParser($uploadedFile);
        $imageParser->generateUniqueName(['avatar.jpg']);

        $this->assertSame($imageParser->getName(),'avatar-1.jpg');
    }

    public function testIfImageDetailsAreCorrectAfterReadingFromDisk()
    {

        $uploadedFile = UploadedFile::fake()->image('test.jpg');
        $uploadedFile->storeAs('/','test.jpg','public');
        $this->storage->assertExists('test.jpg');
        $imageParser = new ImageParser('/test.jpg'); //hackfix

        $this->assertSame($imageParser->getName(),'test.jpg');
        $this->assertSame($imageParser->getExtension(),'jpg');
        $this->assertSame($imageParser->getMimeType(),'image/jpeg');
    }


}
