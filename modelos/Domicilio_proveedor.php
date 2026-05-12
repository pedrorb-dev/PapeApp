<?php
    class Domicilio_proveedor extends Conexion {

        public function get_domicilio_proveedor(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT d.id_domicilio_proveedor, p.nombre_proveedor, d.calle, d.ciudad, d.numero,
            d.colonia, d.codigo_postal FROM
            domicilio_proveedor as d
            LEFT JOIN proveedor as p ON p.id_proveedor = d.id_proveedor";
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