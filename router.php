<?php
require_once 'app/libs/router.php';
require_once 'app/controller/biblioteca.api.controller.php';

$router = new Router();

$router->addRoute('api/libros','GET','BibliotecaApiController','getAll');
$router->addRoute('api/libros/:id','PUT','BibliotecaApiController','edit');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);