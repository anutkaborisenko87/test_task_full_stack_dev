<?php

use testFullStackDev\BaseClasses\Application;
use testFullStackDev\BaseClasses\Request;

require_once 'vendor/autoload.php';
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
session_start();

session_start();
$app = new Application(new Request());
$app->run();