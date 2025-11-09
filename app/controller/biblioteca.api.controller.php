<?php
require_once './app/model/biblioteca.model.php';
require_once './app/view/json.view.php';

class BibliotecaApiController{
    private $model;
    private $view;

    public function __construct() {
        $this->view = new JSONView();
        $this->model = new BibliotecaModel();
    }

    public function getAll($req, $res) {
        $orderBy = false;
        $forma = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
            if(isset($req->query->forma)){
                $forma = strtoupper($req->query->forma);
            }
        }
            
        $libros = $this->model->getLibros($orderBy,$forma);
        if($libros == 'error base'){
            return $this->view->response(["error" => "No existe la base de datos"],500);
        }
        if($libros == 'otro error'){
            return $this->view->response(["error" => "Error del servidor"],500);
        }
        if($libros == 'error sintaxis'){
            return $this->view->response(["error" => "Mala request"],400);
        }
        if($libros == 'error tabla'){
            return $this->view->response(["error" => "No existe la tabla"],404);
        }
        if($libros == null || count($libros) == 0){
            return $this->view->response(["mensaje" => "No hay datos para mostrar"],200);
        }
        return $this->view->response($libros);
    }
}