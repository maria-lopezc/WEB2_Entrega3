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
        $librosPaginados=array();
        $orderBy = false;
        $forma = false;
        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
            if(isset($req->query->forma)){
                $forma = strtoupper($req->query->forma);
            }
        }

        $items = false;
        $pagina = 1;
        if(isset($req->query->items)){
            $items = $req->query->items;
            if(isset($req->query->pagina)){
                $pagina = strtoupper($req->query->pagina);
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

        if($items){
            $i=1;
            $cantPaginas=ceil(sizeof($libros)/$items);
            $limInf=(($pagina-1)*$items);
            $limSup=$pagina*$items;
            if($pagina<=$cantPaginas){
                foreach($libros as $libro){
                    if($i<=$limSup&&$i>$limInf){
                        array_push($librosPaginados,$libro);
                    }
                    $i+=1;
                }
            }
            return $this->view->response($librosPaginados);
        }
         
        return $this->view->response($libros);
    }

    public function edit($req, $res){
        $id = $req->params->id;

        $libro = $this->model->getLibro($id);
        if (!$libro) {
            return $this->view->response(["error" => "El libro con el id=$id no existe"], 404);
        }
        //var_dump($req->body->id_autor);
        if (empty($req->body->id_autor)){
            return $this->view->response(["error" => "Faltan completar id_autor"], 400);
        }
        $id_autor = $req->body->id_autor; 
        $autor= $this->model->getAutor($id_autor);
        if (!$autor) {
            return $this->view->response(["error" => "El autor con el id=$id_autor no existe"], 404);
        }
        if (empty($req->body->titulo)){
            return $this->view->response(["error" => "Faltan completar titulo"], 400);
        }
        if (empty($req->body->genero)){
            return $this->view->response(["error" => "Faltan completar genero"], 400);
        }
        if (empty($req->body->paginas)){
            return $this->view->response(["error" => "Faltan completar paginas"], 400);
        }
    
       
        $titulo = $req->body->titulo;       
        $genero = $req->body->genero;
        $paginas = $req->body->paginas;

        $libro=$this->model->updateLibro($id, $id_autor, $titulo, $genero, $paginas);

        if($libro == 'error key'){
            return $this->view->response(["error" => "No existe el autor"], 400);
        }else if($libro == 'otro error'){
            return $this->view->response(["error" => "Error del servidor"],500);
        }
        
        $libro = $this->model->getLibro($id);
        $this->view->response($libro, 200);
    }
}