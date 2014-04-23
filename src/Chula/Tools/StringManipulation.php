<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 15/01/14
 * Time: 17:55
 */

namespace Chula\Tools;


class StringManipulation
{

    public static function toSlug($string, $space = "-")
    {
        if (function_exists('iconv')) {
            $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        }
        $string = preg_replace("/[^a-zA-Z0-9 -]/", "", $string);
        $string = strtolower($string);
        $string = str_replace(" ", $space, $string);
        return $string;
    }

} 