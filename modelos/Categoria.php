<?php
    class Categoria extends Conexion {
        public function get_categoria() {
            //como si en java hiciera super().conectar();
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM categoria";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_categoria_id($id_cat) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_cat);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_categoria($nombre_cat) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO categoria(id_categoria, nombre_categoria) VALUES (NULL, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $nombre_cat);
            $sql->execute();
        }

    }
?>