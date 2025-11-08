<?php
require_once './app/model/biblioteca.model.php';
require_once './app/view/json.view.php';

class BibliotecaApiController{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new BibliotecaModel();
        $this->view = new JSONView();
    }

    public function getAll($req, $res) {
        $libros = $this->model->getLibros();
        if($libros == null || count($libros) == 0){
            return $this->view->response("No hay libros",204);
        }
        return $this->view->response($libros);
    }
}