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

        public function insert_pedido($estado, $id_prov) {
            $conectar = parent::conectar();
            parent::set_names();

            #solo se inserta id del proveedor y estado del pedido porque los pedidos se separan por proveedodr?
            $sql = "INSERT INTO pedido(id_pedido, id_proveedor, fecha_pedido, estado) 
                        VALUES (NULL, ?, NULL, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(2, $id_prov);
            $sql -> bindValue(3, $estado);

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