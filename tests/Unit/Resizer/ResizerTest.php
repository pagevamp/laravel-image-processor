<?php

namespace Pagevamp\Tests\Unit\Resizer;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Pagevamp\Exceptions\NoSizeDefined;
use Pagevamp\Parser\ImageParser;
use Pagevamp\Resizer\Resizer;
use Pagevamp\Tests\AbstractTestCase;

class ResizerTest extends AbstractTestCase
{

    public function testExceptionWhenWrongDataTypeIsGiven()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');
        $imageParser = new ImageParser($uploadedFile);
        $imageManager = new ImageManager();
        $this->expectException(NoSizeDefined::class);
        $resizer = new Resizer($imageParser, $imageManager, 123);
    }

    public function testIfResizeWorksWhenImageIsUploaded()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');
        $imageParser = new ImageParser($uploadedFile);
        $imageManager = new ImageManager();
        $resizer = (new Resizer($imageParser, $imageManager, ['small' => [100, 100], 'medium' => [400,false],'large' => [1000,1000]] ))->resize();
        $resizer->uploadResizedImages();

        $this->assertSame(3,$resizer->getResizedImages()->count());
        $this->storage->assertExists('avatar.jpg');
        $this->storage->assertExists('small/avatar.jpg');
        $this->storage->assertExists('medium/avatar.jpg');
        $this->storage->assertExists('large/avatar.jpg');

    }

    public function testIfResizeWorksWhenImagePathIsGiven()
    {

        $uploadedFile = UploadedFile::fake()->image('test.jpg');
        $uploadedFile->storeAs('/','test.jpg','public');
        $this->storage->assertExists('test.jpg');
        $imageParser = new ImageParser('/test.jpg'); //hackfix

        $imageManager = new ImageManager();
        $resizer = (new Resizer($imageParser, $imageManager, ['small' => [100, 100], 'medium' => [400,false],'large' => [1000,1000]] ))->resize();
        $resizer->uploadResizedImages();

        $this->assertSame(3,$resizer->getResizedImages()->count());
        $this->storage->assertExists('/avatar.jpg');
        $this->storage->assertExists('small/avatar.jpg');
        $this->storage->assertExists('medium/avatar.jpg');
        $this->storage->assertExists('large/avatar.jpg');

    }

}
