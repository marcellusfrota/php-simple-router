<?php 

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";
$route = new Router\Router;

$route->get("/", "pedidosController@sampleIndex");
$route->get("/list", "pedidosController@samplePedidoDescription");
$route->get("/{foo}/{bar}", "pedidosController@sampleRequest");