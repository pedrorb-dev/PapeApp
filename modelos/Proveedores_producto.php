<?php
    class Proveedores_producto extends Conexion {

        public function insertar_proveedor_producto(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM proveedores_producto";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        #se piden ambos id porque la primary key de esta tabla es una clave compuesta
        public function get_proveedor_prod_id($id_proveedor, id_producto) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM proveedores_producto WHERE id_proveedor = ? AND id_producto = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_proveedor);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_proveedor_producto($id_prod, $id_prov) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO proveedores_producto(id_proveedor, id_producto) 
                        VALUES (?, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prov);
            $sql -> bindValue(2, $id_prod);
            $sql->execute();
        }

        public function delete_proveedor_producto($id_prov, id_prod) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM proveedores_producto WHERE id_proveedor = ? AND id_producto = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prov);
            $sql -> bindValue(2, $id_prod);
            $sql->execute();
        }

        public function update_proveedor_producto($id_prov, $id_prod) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE proveedores_producto
                        SET id_proveedor, id_producto
                        WHERE id_proveedor=? AND id_producto = ?";
            $sql = $conectar -> prepare($sql);

            $sql -> bindValue(1, $id_prov);
            $sql -> bindValue(2, $id_prod);

            $sql->execute();
        }

    }
?>