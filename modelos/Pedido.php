<?php
    class Pedido extends Conexion {

        public function get_pedido(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM pedido";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_pedido_id($id_pedido) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM pedido WHERE id_pedido = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_pedido);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_pedido($id_proveedor, $estado) {
            $conectar = parent::conectar();
            parent::set_names();

            #solo se inserta id del proveedor y estado del pedido
            $sql = "INSERT INTO pedido(id_pedido, id_proveedor, fecha_pedido, estado) 
                        VALUES (NULL, ?, NULL, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_proveedor);
            $sql -> bindValue(2, $estado);

            $sql->execute();
        }

        public function delete_pedido($id_pedido) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM pedido WHERE id_pedido = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_pedido);
            $sql->execute();
        }
    

    }
?>