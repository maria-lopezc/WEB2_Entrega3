<?php
require_once 'app/libs/router.php';
require_once 'app/controller/biblioteca.api.controller.php';

$router = new Router();

$router->addRoute('libros','GET','BibliotecaApiController','getAll');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);