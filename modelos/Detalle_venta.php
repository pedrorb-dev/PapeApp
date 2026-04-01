<?php
    class DetalleVenta extends Conexion{

        public function get_detalle_venta(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_venta"
            $sql = $conectar->prepare($sql);
            $sql->exeute();

            $respuesta = $sql-> fetchAll();

            return $respuesta;
        }

        public function get_detalle_venta_id($id_venta){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM detalle_venta WHERE id_venta=?"
            $sql = $conectar->prepare($sql);
            $sql -> bindValue(1, $id_venta);
            $sql->exeute();

            $respuesta = $sql-> fetchAll();
            return $respuesta;
        }

            #el precio unitario viene dentro de la tabla PRODUCTOS
        public function insert_detalle_venta($id_venta, $id_prod, $cantidad){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO detalle_venta(                      #null para precio unitario?
            id_detalle_venta, id_venta, id_producto, cantidad, precio) VALUES (NULL, ?, ?, ?, NULL)"
            $sql = $conectar->prepare($sql);
            $sql -> bindValue(1, $id_venta);
            $sql -> bindValue(2, $id_prod);
            $sql -> bindValue(3, $cantidad);
            $sql->exeute();
        }

        #no editar id_venta ni precio porque viene de prodictos
        public function update_detalle_venta($id_detalle, $id_prod, $cantidad){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE detalle_venta SET id_producto = ? , cantidad = ?, WHERE id_detalle_venta = ?"
            $sql = $conectar->prepare($sql);
        
            $sql -> bindValue(1, $id_prod);
            $sql -> bindValue(2, $cantidad);
            $sql -> bindValue(3, $id_detalle);
            $sql->exeute();
        }

        public function delete_detalle_venta($id_detalle){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM detalle_venta WHERE id_detalle_venta = ?";
            $sql = $conectar-> prepare(sql);

            $sql -> bindValue(1, $id_detalle);
            $sql->execute();
        }

    }

?>