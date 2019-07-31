<?php

namespace Pagevamp\Resizer;


use Intervention\Image\ImageManager;
use Pagevamp\Exceptions\NoSizeDefined;
use Pagevamp\Parser\ImageParser;

class Resizer
{
    private $editor;
    private $sizes;
    private $image;
    private $resizedImages;

    /**
     * Resizer constructor.
     * @param ImageParser $image
     * @param ImageManager $editor
     * @param array $sizes e.g ['small' => 100,200]
     */
    public function __construct(ImageParser $parser, ImageManager $editor, $sizes)
    {
        $this->image = $parser;
        $this->editor = $editor;
        $this->sizes = $sizes;
        $this->resizedImages = collect();
        $this->filterProcessableData();

        return $this;
    }

    public function resize()
    {
        foreach ($this->sizes as $key => $size) {
            list($width, $height) = $size;
            $image = $this->editor->make($this->image->getContent())->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            $this->resizedImages->push(new ResizedImage($this->image, $image, $key, $size));
        }

        return $this;
    }

    public function getResizedImages()
    {
        return $this->resizedImages;
    }

    public function uploadResizedImages()
    {
        $this->resizedImages->each(function ($resizedImage) {
            $resizedImage->upload();
        });

        return $this;
    }

    private function filterProcessableData()
    {
        if (empty($this->sizes) || !is_array($this->sizes)) {
            throw new NoSizeDefined(' No size has been defined e.g ["small" => [100,200]]');
        }
    }
}
