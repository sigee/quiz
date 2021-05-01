<?php

use Theoduin\Router\Router;

include '../vendor/autoload.php';
session_start();

$router = new Router();

$router->get('/', '\Controller\Home@index');

// API
$router->get('/api/game/start', '\Controller\Api\Game@start');
$router->get('/api/game/restart', '\Controller\Api\Game@restart');
$router->get('/api/game/status', '\Controller\Api\Game@status');
$router->post('/api/game/select', '\Controller\Api\Game@select');

// @TODO: Remove it!!!
$router->get('/api/game/stop', '\Controller\Api\Game@stop');

$router->dispatch();
