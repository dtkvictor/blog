<?php

namespace App\Http\Helpers;

class Generic 
{
    static function stringToArrayAssociative(string $value)
    {
        $array = explode('/', $value);
        $arrayAssociative = [];

        for($i = 0; $i < count($array); $i += 2) {            
            if(!isset($array[$i+1])) continue;
            $key = $array[$i];
            $value = $array[$i + 1];
            $arrayAssociative[$key] = $value;
        }

        return $arrayAssociative;
    }
}