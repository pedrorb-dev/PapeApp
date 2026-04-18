<?php
    class Domicilio_proveedor extends Conexion {

        public function get_domicilio_proveedor(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM domicilio_proveedor";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_domicilio_proveedor_id($id_domicilio) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM domicilio_proveedor WHERE id_domicilio_proveedor = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_domicilio);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_domicilio_proveedor($id_proveedor, $calle, $ciudad, $numero, $colonia, $cp) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO domicilio_proveedor(id_domicilio_proveedor, id_proveedor, calle, ciudad, numero, colonia, codigo_postal) 
                        VALUES (NULL, ?, ?, ?, ?, ?, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_proveedor);
            $sql -> bindValue(2, $calle);
            $sql -> bindValue(3, $ciudad);
            $sql -> bindValue(4, $numero);
            $sql -> bindValue(5, $colonia);
            $sql -> bindValue(6, $cp);
            $sql->execute();
        }

        public function delete_domicilio_proveedor($id_domicilio) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM domicilio_proveedor WHERE id_domicilio_proveedor = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_domicilio);
            $sql->execute();
        }

        public function update_domicilio_proveedor($id_domicilio, $id_proveedor, $calle, $ciudad, $numero, $colonia, $cp) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE domicilio_proveedor
                        SET id_proveedor =?, 
                        calle =?,
                        ciudad =?, 
                        numero = ?,
                        colonia = ?,
                        codigo_postal = ?
                        WHERE id_domicilio_proveedor=?";
            $sql = $conectar -> prepare($sql);

            $sql -> bindValue(1, $id_proveedor);
            $sql -> bindValue(2, $calle);
            $sql -> bindValue(3, $ciudad);
            $sql -> bindValue(4, $numero);
            $sql -> bindValue(5, $colonia);
            $sql -> bindValue(6, $cp);
            $sql -> bindValue(7, $id_domicilio);

            $sql->execute();
        }

    }
?>