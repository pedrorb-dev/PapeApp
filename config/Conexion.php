<?php
    class Conexion {
        protected $dbhost;
        public function conectar() {
            try {
                $conecto = $this ->dbhost = new PDO("mysql:host=localhost;dbname=papeleria_db", "root", "#xPedro18");
                return $conecto;
            } catch (PDOException $e) {
                print $except->getMessage()."<br>";
                die();
            }
        }

        public function set_names() {
            return $this->dbhost->query("SET NAMES 'utf8'");
        }
    }
?>