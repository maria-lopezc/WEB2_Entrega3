<?php
require 'config/config.php';
class BibliotecaModel{
    private $db;
    private $dbError;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        } catch (PDOException $e) {
            $codigo=$e->getCode();
            if ($codigo == 1049) {
                $this->dbError = 'error base';
            }else{
                $this->dbError = 'otro error';
            }
            $this->db=null;
        }
        
    }

    public function getLibros($orderBy=false,$forma=false) {
        if ($this->dbError) {
            return $this->dbError; 
        }
        try {
            $sql='SELECT * FROM `libros`';
            if($orderBy){
                switch($orderBy) {
                    case 'paginas':
                        $sql .= ' ORDER BY paginas';
                        break;
                    case 'autor':
                        $sql .= ' ORDER BY id_autor';
                        break;
                    case 'titulo':
                        $sql .= ' ORDER BY titulo';
                        break;
                    case 'genero':
                        $sql .= ' ORDER BY genero';
                        break;
                }
                if($forma){
                    switch($forma) {
                        case 'ASC':
                            $sql .= ' ASC';
                            break;
                        case 'DESC':
                            $sql .= ' DESC';
                            break;
                        default:
                            $sql .= ' ASC';
                            break;
                    }
                }
            }
        
            $query = $this->db->prepare($sql);
            $query->execute();
            $libros = $query->fetchAll(PDO::FETCH_OBJ); 
            return $libros;
        } catch (PDOException $e) {
            $codigo=$e->getCode();
            switch ($codigo) {
                case '42S02':
                    return 'error tabla';
                case '42000':
                    return 'error sintaxis';
                default:
                    return 'otro error';
            }
        }
    }

    public function getLibro($id){
        $query = $this->db->prepare('SELECT * FROM libros WHERE id_libro=?');
        $query->execute([$id]);
        $libro = $query->fetch(PDO::FETCH_OBJ);
        return $libro;
    }

    public function getAutor($id){
        $query = $this->db->prepare('SELECT * FROM autores WHERE id_autor=?');
        $query->execute([$id]);
        $autor = $query->fetch(PDO::FETCH_OBJ);
        return $autor; 
    }
        

    public function updateLibro($id, $id_autor, $titulo, $genero, $paginas){
        try {
            $query = $this->db->prepare('UPDATE `libros` SET `id_autor` = ?, `titulo` = ?, `genero` = ?, `paginas` = ? WHERE `libros`.`id_libro` = ?');
            $query->execute([$id_autor,$titulo,$genero,$paginas,$id]);
            $libro = $query->fetch(PDO::FETCH_OBJ);
            return $libro;
        } catch (PDOException $e) {
            $codigo=$e->getCode();
            switch ($codigo) {
                case '23000':
                    return 'error key';
                default:
                    return 'otro error';
            }
        }
    }
}