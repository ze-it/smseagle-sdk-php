<?php

if (!function_exists('array_wrap')) {
    function array_wrap($array)
    {
        return is_array($array) ? $array : [$array];
    }
}

if (!function_exists('array_only')) {
    function array_only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }
}
