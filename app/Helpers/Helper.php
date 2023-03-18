<?php

namespace App\Helpers;

class Helper
{
    public static function turkishToEnglishCharacters($str){
        $before = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç');
        $after   = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c');

        return str_replace($before, $after, $str);
    }

    public static function url_make($str){
        $clean = self::turkishToEnglishCharacters($str);

        $clean = preg_replace('/[^a-zA-Z0-9 ]/', '', $clean);
        $clean = preg_replace('!\s+!', '-', $clean);

        return strtolower(trim($clean, '-'));
    }
}
