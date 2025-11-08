<?php
require 'config/config.php';
class BibliotecaModel{
    private $db;

    public function __construct() {
       $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
    }

    public function getLibros() {
        $query = $this->db->prepare('SELECT * FROM `libros`');
        $query->execute();
        $libros = $query->fetchAll(PDO::FETCH_OBJ); 
        return $libros;
    }
}