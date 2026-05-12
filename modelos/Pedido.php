<?php
    class Pedido extends Conexion {

    public function get_pedido()
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT p.id_pedido, p.fecha_pedido, p.estado,
                       COUNT(dp.id_detalle_pedido) as num_productos
                FROM pedido p
                LEFT JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
                GROUP BY p.id_pedido
                ORDER BY p.id_pedido DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }

        public function get_pedido_id($id_pedido) {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT pe.*, 
                       dp.id_detalle_pedido, dp.id_producto, dp.cantidad, dp.costo_estimado,
                       p.nombre_producto, p.marca
                FROM pedido pe
                LEFT JOIN detalle_pedido dp ON pe.id_pedido = dp.id_pedido
                LEFT JOIN productos p ON dp.id_producto = p.id_producto
                WHERE pe.id_pedido = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_pedido);
        $sql->execute();
        return $sql->fetchAll();
        }

    public function insert_pedido($estado, $detalles, $id_pedido)
    {
        $conectar = parent::conectar();
        parent::set_names();

        try {
            $conectar->beginTransaction();

            // Insertar cabecera de venta
            $sql1 = "INSERT INTO pedido(id_pedido, fecha_pedido, estado) 
                     VALUES (NULL, NULL, ?)";
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindValue(1, $estado);
            $stmt1->execute();

            $id_pedido = $conectar->lastInsertId();

            // Insertar detalles y actualizar stock
            foreach ($detalles as $detalle) {
                $sql2 = "INSERT INTO detalle_pedido(id_detalle_pedido, id_pedido, id_producto, cantidad, costo_estimado) 
                         VALUES (NULL, ?, ?, ?, ?)";
                $stmt2 = $conectar->prepare($sql2);
                $stmt2->bindValue(1, $id_pedido);
                $stmt2->bindValue(2, $detalle['id_producto']);
                $stmt2->bindValue(3, $detalle['cantidad']);
                $stmt2->bindValue(4, $detalle['costo_estimado']);
                $stmt2->execute();
            }

            $conectar->commit();
            return $id_pedido;

        } catch (Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }

    public function delete_pedido($id_pedido)
    {
         $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();

            
            // Eliminar detalles y venta
            $sql2 = "DELETE FROM detalle_pedido WHERE id_pedido = ?";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $id_pedido);
            $stmt2->execute();
            
            $sql3 = "DELETE FROM pedido WHERE id_pedido = ?";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindValue(1, $id_pedido);
            $stmt3->execute();
            
            $conectar->commit();
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }

    #lo único que se debe permitir editar en pedido es el estado
    public function update_pedido($estado, $id_pedido)
    {
        $conectar = parent::conectar();
        parent::set_names();

        try {

        $sql = "UPDATE pedido 
               SET estado = ? 
               WHERE id_pedido = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_pedido);
        $sql->execute();
        } catch(Exception $e) {
            $conectar->rollBack();
        }
    }


}
?>