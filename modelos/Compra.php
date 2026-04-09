<?php
    class Compra extends Conexion {
        public function get_compra() {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT c.*, p.nombre_proveedor
            FROM compra c
            INNER JOIN proveedor p 
            ON c.id_proveedor = p.id_proveedor"; #join para también mostrar el nombre del proveedor
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_compra_id($id_comp) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM compra WHERE id_compra = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_comp);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_compra($id_prov, $total_comp) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO compra(id_compra, id_proveedor, fecha_compra, total_compra) 
                        VALUES (NULL, ?, now(), ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prov);
            $sql -> bindValue(2, $total_comp);
            $sql->execute();
        }

        public function delete_compra($id_comp) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM compra WHERE id_compra = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_comp);
            $sql->execute();
        }

        public function update_compra($id_prov, $total_comp, $id_compra) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE compra 
                        SET id_proveedor=?
                        SET total_compra=? 
                        WHERE id_compra=?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(2, $total_comp);
            $sql -> bindValue(1, $id_prov);
            $sql -> bindValue(3, $id_compra);
            $sql->execute();
        }
    }
?>