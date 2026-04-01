<?php
    class Proveedor extends Conexion {

        public function get_proveedor(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM proveedor";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_proveedor_id($id_proveedor) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM proveedor WHERE id_proveedor = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_proveedor);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_proveedor($nombre, $correo, $tel1, $tel2, $rfc) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO proveedores(id_proveedor, nombre_proveedor, correo, telefono_1, telefono_2, RFC) 
                        VALUES (NULL, ?, ?, ?, ?, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $nombre);
            $sql -> bindValue(2, $correo);
            $sql -> bindValue(3, $tel1);
            $sql -> bindValue(4, $tel2);
            $sql -> bindValue(5, $rfc);
            $sql->execute();
        }

        public function delete_proveedor($id_proveedor) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM proveedor WHERE id_proveedor = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_proveedor);
            $sql->execute();
        }

        public function update_proveedor($id_proveedor, $nombre, $correo, $tel1, $tel2, $rfc) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE proveedor
                        SET nombre_proveeddor =?,
                        correo =?, 
                        telefono_1 = ?,
                        telefono_2 = ?,
                        RFC = ?
                        WHERE id_proveedor=?";
            $sql = $conectar -> prepare($sql);

            $sql -> bindValue(1, $nombre);
            $sql -> bindValue(1, $correo);
            $sql -> bindValue(3, $tel1);
            $sql -> bindValue(4, $tel2);
            $sql -> bindValue(5, $rfc);
            $sql -> bindValue(6, $id_proveedor);
            $sql->execute();
        }

    }
?>