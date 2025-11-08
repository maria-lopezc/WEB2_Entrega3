<?php
require_once 'app/libs/router.php';
require_once 'app/controller/biblioteca.api.controller.php';

$router = new Router();

//http://localhost/tpe3/libros 
//Para ordenar: ?orderBy=(parámetro) parámetro=id_autor||titulo||genero||paginas
//Ascendiente o Descendiente: &forma=asc||desc
$router->addRoute('libros','GET','BibliotecaApiController','getAll');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);