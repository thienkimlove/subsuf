<?php

namespace App\Helper;

class EncryptHelper
{
    public static function password($text)
    {
        $text = hash('sha1', $text);
        $text = hash('md5', strrev($text));
        $text = hash('sha256', $text);
        $text = hash('ripemd256', $text);
        $text = hash('md5', strrev($text));
        return $text;
    }
}