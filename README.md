# Media upload / resize
A simple package for laravel to upload and resize media without any hassle.

## Installation
Before to start you'll need to clone/download this package locally and then run from the terminal
```bash
$ composer install
```
```bash
$ php artisan vendor:publish
```

## Usage

`env('MEDIA_STORAGE_DRIVER', 's3')` handles the disk `s3` or `public`

  
``` use Pagevamp\Processor;

$processor = new Processor('pv_photo.png');` // accepts path to image

or 

$processor = new Processor($request->file('image'));` // accepts path to image


$processor->resize(['small' => [100,200],'large' => [2000,1000]); // and you can define size and ratio so on

$processor->uploadResizedImages();

or 

$processor->getResizedImages()->each(function ($resizedImage){
           $resizedImage->setName('generatecustomname.jpg');
            $resizedImage->upload();
            $resizedImage->getUploadedfileUrl();
       });
```
       
       

## Features 
* Reads image from request / disk
* Upload original image with unique name with given sets of data 
* Resize image into multiple sizes
* Upload resized images with custom name  with custom path        
* Currently tested with amazons3 and local storage


<a href="https://codeclimate.com/github/ujwaldhakal/image-processor/maintainability"><img src="https://api.codeclimate.com/v1/badges/4a3e5545d7d1bed95506/maintainability" /></a>

[![Build Status](https://travis-ci.com/ujwaldhakal/image-processor.svg?branch=master)](https://travis-ci.com/ujwaldhakal/image-processor)
