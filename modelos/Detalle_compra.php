<?php
    class DetalleCompra extends Conexion {
        public function get_detalle_compra(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_compra";
            $sql = $conectar->prepare($sql);

            $sql->execute();

            $respuesta= $sql -> fetchAll();
            return $respuesta;
        }

        public function get_detalle_compra_id($id_detalle){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_compra WHERE id_detalle_compra = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detalle);
            $sql->execute();

            $respuesta= $sql -> fetchAll();
            return $respuesta;
        }

        #el id detalle es auntincrementable y el costo viene de productos
        public function insert_detalle_compra($id_compra, $id_producto, $cantidad){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO detalle_compra(
            id_detalle_compra, 
            id_compra, 
            id_producto, 
            cantidad, 
            costo_unitario) VALUES (NULL,? , ? ,?, NULL)" #el costo unitario se llena por automático

        }

        public function delete_detalle_compra($id_detalle){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM detalle_compra WHERE id_detalle_compra = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detalle);
            $sql->execute();

        }

        #editar por si hubiera un error, costo no se edita, el id de detalle se necesita para saber cual se edita
        public function update_detalle_compra($id_detalle, $id_producto,  $id_cantidad){
            $conectar = parent::conectar();
            parent::set_names();
            #null en los campos que no se pueden editar?
            $sql = "UPDATE detalle_compra SET 
            id_producto= ?, 
            cantidad = ? WHERE id_detalle_compra = ?"; 

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_producto);
            $sql->bindValue(1, $cantidad);
            $sql->bindValue(1, $id_detalle);
            $sql->execute();

        }
    }
?>