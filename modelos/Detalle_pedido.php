<?php
    class Detalle_pedido extends Conexion {

        public function get_detalle_pedido(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_pedido";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_detalle_pedido_id($id_det) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_pedido WHERE id_detalle_pedido = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_det);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }
        #costo se trae desde la tabla productos
        public function insert_detalle_pedido($id_pedido, $id_producto, $cantidad) {
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

        #lo único que se debe permitir editar en pedido es el estado
        public function update_pedido($estado, $id_pedido) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE pedido 
               SET estado = ? 
               WHERE id_pedido = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $estado);
            $sql->bindValue(2, $id_pedido);
            $sql->execute();
        }
    }


?>