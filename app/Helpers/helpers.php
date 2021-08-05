<?php

if (!function_exists('format_display')) {

    function format_display($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if (!function_exists('format_model')) {

    function format_model($model)
    {
        echo "<pre>";
        print_r($model->toArray());
        echo "</pre>";
    }
}

if (!function_exists('echo_newline')) {

    function echo_newline()
    {
        echo nl2br("\r\n");
    }
}
