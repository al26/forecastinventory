<?php

if(!function_exists('float')) {
    function float($val) {
        return floatval(str_replace(',', '.', $val));
    }
}

if(!function_exists('avg')) {
    function avg(array $data) {
        return array_sum($data) / count($data);
    }
}

