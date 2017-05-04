<?php

namespace App\Helper;

use Image;

class ImageUpload
{

    private static $image_dir = "upload/images/";
    private static $featured_dir = "upload/featured/";
    private static $thumbnail_dir = "upload/thumbnail/";
    private static $avatar_dir = "upload/avatar/";
    private static $order_dir = "upload/order/";
    private static $image_types = ["image/gif" => ".gif", "image/jpeg" => ".jpg", "image/png" => ".png"];

    public static function avatar($file, $name)
    {
        $dir = static::$avatar_dir . date("m");
        $path = $dir . "/" . $name . static::$image_types[$file->getMimeType()];
        if (file_exists($path)) {
            static::remove($path);
        }
        try {
            $avatar = Image::make($file);
        } catch (\Intervention\Image\Exception\NotReadableException $ex) {
            return '';
        }
        $avatar->fit(500);
        try {
            // check if $folder is a directory
            if (!\File::isDirectory($dir)) {
                // 493 = $mode of mkdir() function that is used file File::makeDirectory (493 is used by default in \File::makeDirectory
                // true -> this says, that folders are created recursively here! Example:
                // you want to create a directory in company_img/username and the folder company_img does not
                // exist. This function will fail without setting the 3rd param to true
                // http://php.net/mkdir  is used by this function
                \File::makeDirectory(static::$avatar_dir . date("m"), 493, true);
            }

            if ($avatar->save($path)) {
                return $path;
            }


        } catch (\Intervention\Image\Exception\NotWritableException $ex) {

            return '';
        }
        $avatar->destroy();
        unset($path);
        return '';
    }

    public static function order($file, $name = "")
    {
        $name = str_random(16);
        $dir = static::$order_dir . date("ym");

        $path = $dir . "/" . $name . static::$image_types[$file->getMimeType()];
        if (file_exists($path)) {
            $name = str_random(16);
            $path = $dir . "/" . $name . static::$image_types[$file->getMimeType()];
        }
        try {
            $avatar = Image::make($file);
        } catch (\Intervention\Image\Exception\NotReadableException $ex) {
            return '';
        }
//        $avatar->fit(612);
        try {
            // check if $folder is a directory
            if (!\File::isDirectory($dir)) {
                \File::makeDirectory($dir, 493, true);
            }

            if ($avatar->save($path)) {
                return $path;
            }
        } catch (\Intervention\Image\Exception\NotWritableException $ex) {
            return '';
        }
        $avatar->destroy();
        unset($path);
        return '';
    }


    public static function thumbnail($file, $name = "")
    {
        try {
            $thumbnail = Image::make($file);
        } catch (\Intervention\Image\Exception\NotReadableException $ex) {
            return "uploads/thumbnail/default.png";
        }
        if ($name == "") {
            $name = static::name($file);
        } elseif (isset(static::$image_types[$thumbnail->mime()])) {
            $name .= static::$image_types[$thumbnail->mime()];
        } else {
            $name .= ".jpg";
        }
        $thumbnail->fit(100);
        $path = static::path(static::$thumbnail_dir, $name);
        if (file_exists($path)) {
            static::remove($path);
        }
        try {
            if ($thumbnail->save($path)) {
                return $path;
            }
        } catch (\Intervention\Image\Exception\NotWritableException $ex) {
            return "uploads/thumbnail/default.png";
        }
        $thumbnail->destroy();
        unset($path);
    }

    public static function featured($file, $name = "", $width = 640, $height = 480)
    {
        try {
            $featured = Image::make($file);
        } catch (\Intervention\Image\Exception\NotReadableException $ex) {
            return "uploads/featured/default.png";
        }
        if ($name == "") {
            $name = static::name($file);
        } elseif (isset(static::$image_types[$featured->mime()])) {
            $name .= "-" . $width . "x" . $height . static::$image_types[$featured->mime()];
        } else {
            $name .= ".jpg";
        }
        $featured->fit($width, $height);
        $path = static::path(static::$featured_dir, $name);
        if (file_exists($path)) {
            static::remove($path);
        }
        try {
            if ($featured->save($path)) {
                return $path;
            }
        } catch (\Intervention\Image\Exception\NotWritableException $ex) {
            return "uploads/featured/default.png";
        }
        $featured->destroy();
        unset($path);
    }

    public static function image($file, $name = "")
    {
        try {
            $image = Image::make($file);
        } catch (\Intervention\Image\Exception\NotReadableException $ex) {
            return "uploads/images/default.png";
        }
        if ($name == "") {
            $name = static::name($file);
        } elseif (isset(static::$image_types[$image->mime()])) {
            $name .= static::$image_types[$image->mime()];
        } else {
            $name .= ".jpg";
        }
        $path = static::path(static::$image_dir, $name);
        if (file_exists($path)) {
            static::remove($path);
        }
        try {
            if ($image->save($path)) {
                return $path;
            }
        } catch (\Intervention\Image\Exception\NotWritableException $ex) {
            return "uploads/images/default.png";
        }
        $image->destroy();
        unset($path);
    }

    public static function path($dir, $name)
    {
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $date_dir = [date("Y"), date("m"), date('d')];
        foreach ($date_dir as $value) {
            $dir .= $value . "/";
            if (!is_dir($dir)) {
                mkdir($dir);
            }
        }
        unset($date_dir);
        return $dir . $name;
    }

    public static function remove($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    private static function name($file)
    {
        if (is_string($file)) {
            return round(microtime(true) * 1000) . "-" . basename($file);
        } else {
            return round(microtime(true) * 1000) . "-" . $file->getClientOriginalName();
        }
    }

    public static function is_image($file)
    {
        if (is_string($file)) {
            $image_size = @getimagesize($file);
            if ($image_size) {
                $mime = $image_size['mime'];
                if (array_key_exists($mime, static::$image_types)) {
                    unset($mime);
                    return true;
                }
            }
            unset($image_size);
        } else {
            $mime = $file->getClientMimeType();
            if (array_key_exists($mime, static::$image_types)) {
                unset($mime);
                return true;
            }
        }
        return false;
    }

}
