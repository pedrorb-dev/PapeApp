<?php
    <?php
    class Producto extends Conexion {
        public function get_producto() {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM productos";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_producto_id($id_prod) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT * FROM productos WHERE id_producto = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prod);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function insert_producto($id_cat, $nombre_prod, $descripcion, $precio, $costo, $marca, $min_stock, $stock) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "INSERT INTO 
            productos(id_producto, id_categoria, nombre_producto, descripcion, precio, costo, marca, min_stock, stock) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_cat);
            $sql -> bindValue(2, $nombre_prod);
            $sql -> bindValue(3, $descripcion);
            $sql -> bindValue(4, $precio);
            $sql -> bindValue(5, $costo);
            $sql -> bindValue(6, $marca);
            $sql -> bindValue(7, $min_stock);
            $sql -> bindValue(8, $stock);
            $sql->execute();
        }

        public function delete_producto($id_prod) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "DELETE FROM productos WHERE id_producto = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prod);
            $sql->execute();
        }

        public function update_producto($id_prod, $id_cat, $nombre_prod, $descripcion, $precio, $costo, $marca, $min_stock, $stock) {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "UPDATE productos 
                        SET id_categoria=?,
                        nombre_producto=?,
                        descripcion=?,
                        precio=?,
                        costo=?,
                        marca=?,
                        min_stock=?,
                        stock=?
                        WHERE id_producto=?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_cat);
            $sql -> bindValue(2, $nombre_prod);
            $sql -> bindValue(3, $descripcion);
            $sql -> bindValue(4, $precio);
            $sql -> bindValue(5, $costo);
            $sql -> bindValue(6, $marca);
            $sql -> bindValue(7, $min_stock);
            $sql -> bindValue(8, $stock);
            $sql -> bindValue(9, $id_prod);
            $sql->execute();
        }
    }
?>
?>