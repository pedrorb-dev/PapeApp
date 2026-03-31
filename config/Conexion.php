<?php
    class Conexion {
        protected $dbhost;
        protected function conectar() {
            try {
                $conecto = $this ->dbhost = new PDO("mysql:local=localhost;dbname=papeleria_db", "root", "");
                return $conecto;
            } catch (PDOException $e) {
                echo "Error en la conexión: " . $e->getMessage();
                die();
            }
        }

        public function set_names() {
            echo "utf8";
            return $this->dbhost->query("SET NAMES 'utf8'");
        }
    }

    $conexion = new Conexion();
    echo $conexion -> conectar();
    echo $conexion -> set_names();
?>