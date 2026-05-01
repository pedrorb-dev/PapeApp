<?php
class Venta extends Conexion {
    
    // Obtener todas las ventas con detalles del producto
    public function get_ventas() {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT v.id_venta, v.fecha_venta, v.total_venta,
                       COUNT(dv.id_detalle_venta) as num_productos
                FROM ventas v
                LEFT JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                GROUP BY v.id_venta
                ORDER BY v.id_venta DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    // Obtener venta por ID con sus detalles
    public function get_venta_id($id_venta) {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT v.*, 
                       dv.id_detalle_venta, dv.id_producto, dv.cantidad, dv.precio_unitario,
                       p.nombre_producto, p.marca
                FROM ventas v
                LEFT JOIN detalle_venta dv ON v.id_venta = dv.id_venta
                LEFT JOIN productos p ON dv.id_producto = p.id_producto
                WHERE v.id_venta = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_venta);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    // Insertar venta y sus detalles (transacción)
    public function insert_venta($fecha_venta, $total_venta, $detalles) {
        $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();
            
            // Insertar cabecera de venta
            $sql1 = "INSERT INTO ventas(id_venta, fecha_venta, total_venta) 
                     VALUES (NULL, ?, ?)";
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindValue(1, $fecha_venta);
            $stmt1->bindValue(2, $total_venta);
            $stmt1->execute();
            
            $id_venta = $conectar->lastInsertId();
            
            // Insertar detalles y actualizar stock
            foreach($detalles as $detalle) {
                $sql2 = "INSERT INTO detalle_venta(id_detalle_venta, id_venta, id_producto, cantidad, precio_unitario) 
                         VALUES (NULL, ?, ?, ?, ?)";
                $stmt2 = $conectar->prepare($sql2);
                $stmt2->bindValue(1, $id_venta);
                $stmt2->bindValue(2, $detalle['id_producto']);
                $stmt2->bindValue(3, $detalle['cantidad']);
                $stmt2->bindValue(4, $detalle['precio_unitario']);
                $stmt2->execute();
                
                // Actualizar stock (restar)
                $sql3 = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
                $stmt3 = $conectar->prepare($sql3);
                $stmt3->bindValue(1, $detalle['cantidad']);
                $stmt3->bindValue(2, $detalle['id_producto']);
                $stmt3->execute();
            }
            
            $conectar->commit();
            return $id_venta;
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }
    
    // Eliminar venta (revertir stock)
    public function delete_venta_id($id_venta) {
        $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();
            
            // Obtener detalles para revertir stock
            $sql_detalles = "SELECT id_producto, cantidad FROM detalle_venta WHERE id_venta = ?";
            $stmt_detalles = $conectar->prepare($sql_detalles);
            $stmt_detalles->bindValue(1, $id_venta);
            $stmt_detalles->execute();
            $detalles = $stmt_detalles->fetchAll();
            
            // Revertir stock
            foreach($detalles as $detalle) {
                $sql_revertir = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
                $stmt_revertir = $conectar->prepare($sql_revertir);
                $stmt_revertir->bindValue(1, $detalle['cantidad']);
                $stmt_revertir->bindValue(2, $detalle['id_producto']);
                $stmt_revertir->execute();
            }
            
            // Eliminar detalles y venta
            $sql2 = "DELETE FROM detalle_venta WHERE id_venta = ?";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $id_venta);
            $stmt2->execute();
            
            $sql3 = "DELETE FROM ventas WHERE id_venta = ?";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindValue(1, $id_venta);
            $stmt3->execute();
            
            $conectar->commit();
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }
}
?>