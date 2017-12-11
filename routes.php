<?php

$route = new Router\Router;

$route->get("/", "pedidosController@index");
$route->get("/list", "pedidosController@pedidoDescription");