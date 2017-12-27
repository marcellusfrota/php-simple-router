<?php

$route = new Router\Router;

$route->get("/", "pedidosController@sampleIndex");
$route->get("/list", "pedidosController@samplePedidoDescription");
$route->get("/{foo}/{bar}", "pedidosController@sampleRequest");