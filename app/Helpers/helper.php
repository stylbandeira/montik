<?php

if (!function_exists('not_null')) {
    function not_null($request)
    {
        $not_null = array_filter($request, function ($value) {
            return !is_null($value);
        });

        return $not_null;
    }
}
