<?php

use Theoduin\Router\Router;

include '../vendor/autoload.php';
session_start();

$router = new Router();

$router->get('/', '\Controller\Home@index');

$router->dispatch();
