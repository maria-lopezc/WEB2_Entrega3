<?php
require 'config/config.php';
class BibliotecaModel{
    protected $db;
    private $dbError;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
            $this->_deploy();
        } catch (PDOException $e) {
            $codigo=$e->getCode();
            if ($codigo == 1049) {
                $this->dbError = 'error base';
            }else{
                $this->dbError = 'otro error';
            }
        }
        
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql = <<<END
            CREATE TABLE `autores` (`id_autor` int(11)   AUTO_INCREMENT PRIMARY KEY,`nombre` varchar(100) NOT NULL,`nacimiento` date NOT NULL,`email` varchar(50) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
            INSERT INTO `autores` (`id_autor`, `nombre`, `nacimiento`, `email`) VALUES(1, 'Luciano Añon', '2004-08-03', 'luciano@gmail.com'),(2, 'Julio Verne', '2000-01-01', 'julioverne32@gmail.com'),(3, 'Jose Perez', '1995-06-21', 'joseperez@gmail.com'),(4, 'Juana Rodriguez', '1999-03-08', 'juanarodriguez@gmail.com');
            CREATE TABLE `libros` (`id_libro` int(11)  AUTO_INCREMENT PRIMARY KEY,`id_autor` int(11) NOT NULL,`titulo` varchar(100) NOT NULL,`genero` varchar(100) NOT NULL,`paginas` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
            INSERT INTO `libros` (`id_libro`, `id_autor`, `titulo`, `genero`, `paginas`) VALUES(1, 1, 'El Alquimista', 'Aventura', 100),(2, 3, 'Crimen y castigo', 'Clásico', 500),(3, 3, 'Sherlock Holmes', 'Crimen', 800),(4, 3, 'Hamlet', 'Teatro', 1000),(5, 4, 'El principito', 'Clásico', 2000),(6, 1, 'Martín Fierro', 'Poesia', 500),(7, 2, 'La vuelta al mundo en 80 días', 'Aventura', 4000);
            CREATE TABLE `login` (`id` int(11)  AUTO_INCREMENT PRIMARY KEY,`usuario` varchar(100) CHARACTER SET utf16 COLLATE utf16_spanish_ci NOT NULL,`contrasena` varchar(200) CHARACTER SET utf16 COLLATE utf16_spanish2_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
            INSERT INTO `login` (`id`, `usuario`, `contrasena`) VALUES(1, 'webadmin', '\$2y\$10\$ax3bLQBWYdfetJxumbdezuE/Q0OmSwYwSYeNRPsMYuy.svLI8NjZe');
            ALTER TABLE `libros` ADD CONSTRAINT `autor` FOREIGN KEY (`id_autor`) REFERENCES `autores`(`id_autor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            END;
        $this->db->query($sql);
        }
    }

    public function getLibros($orderBy=false,$forma=false,$items=false,$pagina=1) {
        if ($this->dbError) {
            return $this->dbError; 
        }
        try {
            $sql='SELECT * FROM `libros`';
            if($orderBy){
                switch($orderBy) {
                    case 'id':
                        $sql .= ' ORDER BY id_libro';
                        break;
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
            } else {
                $sql .= ' ORDER BY id_libro';
            }
            if($forma){
                switch($forma) {
                    case 'DESC':
                        $sql .= ' DESC';
                        break;
                    default:
                        $sql .= ' ASC';
                        break;
                }
            }
            if($items){
                $sql .= ' LIMIT '.$items;
                if($pagina){
                    $sql .= ' OFFSET '.$pagina;
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
        if ($this->dbError) {
            return $this->dbError; 
        }
        try {
            $query = $this->db->prepare('SELECT * FROM libros WHERE id_libro=?');
            $query->execute([$id]);
            $libro = $query->fetch(PDO::FETCH_OBJ);
            return $libro;
        } catch(PDOexception $e) {
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

    public function getAutor($id){
        $query = $this->db->prepare('SELECT * FROM autores WHERE id_autor=?');
        $query->execute([$id]);
        $autor = $query->fetch(PDO::FETCH_OBJ);
        return $autor; 
    }
        

    public function updateLibro($id, $id_autor, $titulo, $genero, $paginas){
        if ($this->dbError) {
            return $this->dbError; 
        }
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

    public function addLibro($id_autor, $titulo, $genero, $paginas){
        if ($this->dbError) {
            return $this->dbError; 
        }
        try {
            $query = $this->db->prepare('INSERT INTO libros (id_autor, titulo, genero, paginas) VALUES(?, ?, ?, ?)');
            $query->execute([$id_autor,$titulo,$genero,$paginas]);

            $id = $this->db->lastInsertId();
            $sentencia = $this->db->prepare('SELECT * FROM libros WHERE id_libro = ?');
            $sentencia->execute([$id]);
            $libro = $sentencia->fetch(PDO::FETCH_OBJ);

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
    }}

