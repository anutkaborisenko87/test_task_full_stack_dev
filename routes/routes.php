<?php


use testFullStackDev\BaseClasses\Router;

Router::get('/', function () {
    return response()->json(['data'=> 'Hello']);
});
