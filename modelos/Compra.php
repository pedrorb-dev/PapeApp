<?php
class Compra extends Conexion {
    
    // Obtener todas las compras
    public function get_compras() {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT c.id_compra, c.fecha_compra, c.total_compra,
                       p.nombre_proveedor,
                       COUNT(dc.id_detalle_compra) as num_productos
                FROM compra c
                LEFT JOIN proveedor p ON c.id_proveedor = p.id_proveedor
                LEFT JOIN detalle_compra dc ON c.id_compra = dc.id_compra
                GROUP BY c.id_compra
                ORDER BY c.id_compra DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    // Obtener compra por ID
    public function get_compra_id($id_compra) {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT c.*, p.nombre_proveedor,
                       dc.id_detalle_compra, dc.id_producto, dc.cantidad, dc.costo_unitario,
                       prod.nombre_producto, prod.marca
                FROM compra c
                LEFT JOIN proveedor p ON c.id_proveedor = p.id_proveedor
                LEFT JOIN detalle_compra dc ON c.id_compra = dc.id_compra
                LEFT JOIN productos prod ON dc.id_producto = prod.id_producto
                WHERE c.id_compra = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_compra);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    // Insertar compra (transacción)
    public function insert_compra($id_proveedor, $fecha_compra, $total_compra, $detalles) {
        $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();
            
            // Insertar cabecera de compra
            $sql1 = "INSERT INTO compra(id_compra, id_proveedor, fecha_compra, total_compra) 
                     VALUES (NULL, ?, ?, ?)";
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindValue(1, $id_proveedor);
            $stmt1->bindValue(2, $fecha_compra);
            $stmt1->bindValue(3, $total_compra);
            $stmt1->execute();
            
            $id_compra = $conectar->lastInsertId();
            
            // Insertar detalles y actualizar stock
            foreach($detalles as $detalle) {
                $sql2 = "INSERT INTO detalle_compra(id_detalle_compra, id_compra, id_producto, cantidad, costo_unitario) 
                         VALUES (NULL, ?, ?, ?, ?)";
                $stmt2 = $conectar->prepare($sql2);
                $stmt2->bindValue(1, $id_compra);
                $stmt2->bindValue(2, $detalle['id_producto']);
                $stmt2->bindValue(3, $detalle['cantidad']);
                $stmt2->bindValue(4, $detalle['costo_unitario']);
                $stmt2->execute();
                
                // Actualizar stock (sumar)
                $sql3 = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
                $stmt3 = $conectar->prepare($sql3);
                $stmt3->bindValue(1, $detalle['cantidad']);
                $stmt3->bindValue(2, $detalle['id_producto']);
                $stmt3->execute();
            }
            
            $conectar->commit();
            return $id_compra;
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }
    public function get_compra_with_details($id_compra) {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT c.*, p.nombre_proveedor,
                    dc.id_detalle_compra, dc.id_producto, dc.cantidad, dc.costo_unitario,
                    prod.nombre_producto, prod.marca, prod.precio
                FROM compra c
                LEFT JOIN proveedor p ON c.id_proveedor = p.id_proveedor
                LEFT JOIN detalle_compra dc ON c.id_compra = dc.id_compra
                LEFT JOIN productos prod ON dc.id_producto = prod.id_producto
                WHERE c.id_compra = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_compra);
        $sql->execute();
        
        $resultado = $sql->fetchAll();
        
        if(count($resultado) > 0) {
            $compra = array(
                'id_compra' => $resultado[0]['id_compra'],
                'id_proveedor' => $resultado[0]['id_proveedor'],
                'nombre_proveedor' => $resultado[0]['nombre_proveedor'],
                'fecha_compra' => $resultado[0]['fecha_compra'],
                'total_compra' => $resultado[0]['total_compra'],
                'detalles' => array()
            );
            
            foreach($resultado as $row) {
                if($row['id_producto']) {
                    $compra['detalles'][] = array(
                        'id_detalle_compra' => $row['id_detalle_compra'],
                        'id_producto' => $row['id_producto'],
                        'nombre_producto' => $row['nombre_producto'],
                        'cantidad' => $row['cantidad'],
                        'costo_unitario' => $row['costo_unitario'],
                        'marca' => $row['marca'],
                        'precio_venta' => $row['precio']
                    );
                }
            }
            return $compra;
        }
        return null;
    }
    // Eliminar compra (revertir stock)
    public function delete_compra_id($id_compra) {
        $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();
            
            // Obtener detalles para revertir stock
            $sql_detalles = "SELECT id_producto, cantidad FROM detalle_compra WHERE id_compra = ?";
            $stmt_detalles = $conectar->prepare($sql_detalles);
            $stmt_detalles->bindValue(1, $id_compra);
            $stmt_detalles->execute();
            $detalles = $stmt_detalles->fetchAll();
            
            // Revertir stock (restar lo que se sumó)
            foreach($detalles as $detalle) {
                $sql_revertir = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
                $stmt_revertir = $conectar->prepare($sql_revertir);
                $stmt_revertir->bindValue(1, $detalle['cantidad']);
                $stmt_revertir->bindValue(2, $detalle['id_producto']);
                $stmt_revertir->execute();
            }
            
            // Eliminar detalles y compra
            $sql2 = "DELETE FROM detalle_compra WHERE id_compra = ?";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $id_compra);
            $stmt2->execute();
            
            $sql3 = "DELETE FROM compra WHERE id_compra = ?";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindValue(1, $id_compra);
            $stmt3->execute();
            
            $conectar->commit();
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }

    public function update_compra($id_compra, $id_proveedor, $detalles_nuevos) {
        $conectar = parent::conectar();
        parent::set_names();
        
        try {
            $conectar->beginTransaction();
            
            // 1. Obtener detalles antiguos
            $sql_old = "SELECT id_producto, cantidad FROM detalle_compra WHERE id_compra = ?";
            $stmt_old = $conectar->prepare($sql_old);
            $stmt_old->bindValue(1, $id_compra);
            $stmt_old->execute();
            $detalles_viejos = $stmt_old->fetchAll();
            
            // 2. Revertir stock antiguo (restar lo que se sumó)
            foreach($detalles_viejos as $viejo) {
                $sql_revertir = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
                $stmt_revertir = $conectar->prepare($sql_revertir);
                $stmt_revertir->bindValue(1, $viejo['cantidad']);
                $stmt_revertir->bindValue(2, $viejo['id_producto']);
                $stmt_revertir->execute();
            }
            
            // 3. Eliminar detalles antiguos
            $sql_del = "DELETE FROM detalle_compra WHERE id_compra = ?";
            $stmt_del = $conectar->prepare($sql_del);
            $stmt_del->bindValue(1, $id_compra);
            $stmt_del->execute();
            
            // 4. Insertar nuevos detalles y actualizar stock
            $total_compra = 0;
            foreach($detalles_nuevos as $detalle) {
                // Insertar detalle
                $sql_insert = "INSERT INTO detalle_compra(id_detalle_compra, id_compra, id_producto, cantidad, costo_unitario) 
                            VALUES (NULL, ?, ?, ?, ?)";
                $stmt_insert = $conectar->prepare($sql_insert);
                $stmt_insert->bindValue(1, $id_compra);
                $stmt_insert->bindValue(2, $detalle['id_producto']);
                $stmt_insert->bindValue(3, $detalle['cantidad']);
                $stmt_insert->bindValue(4, $detalle['costo_unitario']);
                $stmt_insert->execute();
                
                // Actualizar stock (sumar nuevo)
                $sql_update = "UPDATE productos SET stock = stock + ? WHERE id_producto = ?";
                $stmt_update = $conectar->prepare($sql_update);
                $stmt_update->bindValue(1, $detalle['cantidad']);
                $stmt_update->bindValue(2, $detalle['id_producto']);
                $stmt_update->execute();
                
                $total_compra += $detalle['cantidad'] * $detalle['costo_unitario'];
            }
            
            // 5. Actualizar cabecera de compra
            $sql_update_compra = "UPDATE compra SET id_proveedor = ?, total_compra = ? WHERE id_compra = ?";
            $stmt_update_compra = $conectar->prepare($sql_update_compra);
            $stmt_update_compra->bindValue(1, $id_proveedor);
            $stmt_update_compra->bindValue(2, $total_compra);
            $stmt_update_compra->bindValue(3, $id_compra);
            $stmt_update_compra->execute();
            
            $conectar->commit();
            return true;
            
        } catch(Exception $e) {
            $conectar->rollBack();
            throw $e;
        }
    }

    
}
?>