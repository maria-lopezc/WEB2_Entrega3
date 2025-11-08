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
        $orderBy = false;
        $forma = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
            if(isset($req->query->forma)){
                $forma = strtoupper($req->query->forma);
            }
        }
            
        $libros = $this->model->getLibros($orderBy,$forma);
        if($libros == null || count($libros) == 0){
            return $this->view->response("No hay libros",204);
        }
        return $this->view->response($libros);
    }
}