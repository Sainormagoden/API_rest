<?php

require_once "Autoloader.php";
header('Content-Type: application/json;charset=utf-8');

$router = new Router($_GET['url']);
$router->get('/', function(){ echo json_encode("Bienvenue sur mon API!"); });
//$router->get('/user/:allData', "User#userByallData");
$router->get('/user', "User#UserByQuery");
$router->run();

