<?php
    class Reporte extends Conexion {
        public function get_top_productos($limite = 10, $fecha_inicio = null, $fecha_fin = null) {
            $conectar = parent::conectar();
            parent::set_names();
            
            $sql = "SELECT p.id_producto, p.nombre_producto, 
                        SUM(dv.cantidad) as total_vendido,
                        SUM(dv.cantidad * dv.precio_unitario) as total_recaudado
                    FROM detalle_venta dv
                    JOIN ventas v ON dv.id_venta = v.id_venta
                    JOIN productos p ON dv.id_producto = p.id_producto
                    WHERE 1=1";
            
            if ($fecha_inicio && $fecha_fin) {
                $sql .= " AND DATE(v.fecha_venta) BETWEEN ? AND ?";
            }
            
            $sql .= " GROUP BY p.id_producto
                    ORDER BY total_vendido DESC
                    LIMIT ?";
            
            $stmt = $conectar->prepare($sql);
            
            if ($fecha_inicio && $fecha_fin) {
                $stmt->bindValue(1, $fecha_inicio);
                $stmt->bindValue(2, $fecha_fin);
            }
            $stmt->bindValue(3, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>