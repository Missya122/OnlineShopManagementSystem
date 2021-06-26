<?php

namespace Core;

class Image
{
    public static function imagesToUploadCount()
    {
        return count($_FILES);
    }

    public static function uploadImage($source, $destination)
    {
        $image = self::getUploadedImage($source);

        if($image) {
            $tempname = $image['tmp_name'];

            move_uploaded_file($tempname, $destination);
        }
    }

    public static function getUploadedImage($key)
    {
        foreach($_FILES as $file_key => $file) {
            if($key === $file_key) {
                return $file;
            }
        }

        return null;
    }

    public static function isImageCorrect($image)
    {
        return $image['error'] || !$image['size'] || !$image['name'] || !$image['type'];
    }
}

