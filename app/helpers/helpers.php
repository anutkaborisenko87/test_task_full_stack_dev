<?php

use testFullStackDev\BaseClasses\Response;

/**
 * @param ...$vars
 * @return void
 */
function dd(...$vars)
{
    echo '<style>pre {background-color:#4f4c4c;border:1px solid #1b2026;padding:10px;margin:20px; color: #7fc002}</style>';
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    die();
}

/**
 * @param ...$vars
 * @return void
 */
function dump(...$vars)
{
    echo '<style>pre {background-color:#4f4c4c;border:1px solid #1b2026;padding:10px;margin:20px; color: #7fc002}</style>';
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

/**
 * @return Response
 */
function response(): Response
{
    return new Response('');
}

/**
 * @param $key
 * @param $default
 * @return mixed|null
 */
function config($key, $default = null)
{

    $config = [
        "db_port" => "3306",
        "db_host" => "localhost",
        "db_name" => "test_full_stack_dev",
        "db_user" => "root",
        "db_pass" => "",
    ];

    return $config[$key] ?? $default;
}