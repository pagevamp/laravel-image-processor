<?php

namespace Pagevamp\Tests\Unit\Resizer;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Pagevamp\Exceptions\NoSizeDefined;
use Pagevamp\Parser\ImageParser;
use Pagevamp\Resizer\Resizer;
use Pagevamp\Tests\AbstractTestCase;
use Pagevamp\Uploader\Uploader;

class UploaderTest extends AbstractTestCase
{

    public function testUploaderWhenImageIsUploaded()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');
        $imageParser = new ImageParser($uploadedFile);
        $uploader = (new Uploader($imageParser, app(Storage::class),'/custom'))->upload();
        $this->assertSame('app.test/storage/custom/avatar.jpg',$uploader->getAbsolutePath());
        $this->assertSame('/custom/avatar.jpg',$uploader->getRelativePath());
    }




    public function testUploaderWhenImageIsReadFromPath()
    {
        $uploadedFile = UploadedFile::fake()->image('test.jpg');
        $uploadedFile->storeAs('/custom','test.jpg','public');
        $this->storage->assertExists('test.jpg');
        $imageParser = new ImageParser('/custom/test.jpg'); //hackfix

        $uploader = (new Uploader($imageParser, app(Storage::class),'/custom'))->upload();
        $this->assertSame('app.test/storage/custom/test.jpg',$uploader->getAbsolutePath());
        $this->assertSame('/custom/test.jpg',$uploader->getRelativePath());
    }


}
