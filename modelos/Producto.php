<?php
    class Producto extends Conexion {
        public function get_producto() {
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT c.nombre_categoria, p.id_producto, p.nombre_producto, p.descripcion,
            p.precio, p.costo, p.marca, p.min_stock, p.stock FROM productos as p 
            LEFT JOIN categoria as c
            ON p.id_categoria = c.id_categoria";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_producto_id($id_prod) { //consulta un producto pidiendo id
            $conectar = parent::conectar(); //conecta  a la base de datos
            parent::set_names();

            $sql = "SELECT * FROM productos WHERE id_producto = ?"; //consulta sql
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $id_prod); //relaciona ? al id del producto
            $sql->execute(); //ejecuta la consulta
            $respuesta = $sql -> fetchAll(); //obtiene la respuesta de la consulta
            return $respuesta; //retorna la respuesta
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

        public function delete_producto_id($id_prod) {
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

        public function get_productos_faltantes(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT id_producto, nombre_producto, stock, min_stock 
                        FROM productos 
                        WHERE stock <= min_stock";
            $sql = $conectar -> prepare($sql);
            $sql->execute();
            $respuesta = $sql -> fetchAll();
            return $respuesta;
        }

        public function get_productos_bajo_stock()
        {

            $conectar = parent::conectar(); //se contecta a la base de datos
            parent::set_names();

            $sql = "SELECT COUNT(*) AS total
                FROM productos
                WHERE stock <= min_stock";

            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_ASSOC);
        }

        public function get_total_productos(){
            $conectar = parent::conectar();
            parent::set_names();

            $sql = "SELECT COUNT(*) AS total_productos
                FROM productos";

            $sql = $conectar->prepare($sql);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
?>