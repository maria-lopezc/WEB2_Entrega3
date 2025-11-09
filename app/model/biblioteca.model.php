<?php
require 'config/config.php';
class BibliotecaModel{
    private $db;

    public function __construct() {
       $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
    }

    public function getLibros($orderBy=false,$forma=false) {
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
}