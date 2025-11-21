<?php
require_once 'app/libs/router.php';
require_once 'app/controller/biblioteca.api.controller.php';

$router = new Router();

//GET
$router->addRoute('api/libros','GET','BibliotecaApiController','getAll');
//PUT
$router->addRoute('api/libros/:id','PUT','BibliotecaApiController','edit');

//GET
$router->addRoute('api/libros/:id','GET','BibliotecaApiController','get');

//POST
$router -> addRoute('api/libros/', 'POST', 'BibliotecaApiController', 'add');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

