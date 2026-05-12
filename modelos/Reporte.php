<?php
class Reporte extends Conexion {
    public function get_top_productos($limite = 10) {
        $conectar = parent::conectar();
        parent::set_names();
        
        $sql = "SELECT p.id_producto,
                       p.nombre_producto,
                       p.marca,
                       SUM(dv.cantidad) as total_vendido,
                       SUM(dv.cantidad * dv.precio_unitario) as total_recaudado,
                       p.stock
                FROM detalle_venta dv
                JOIN productos p ON dv.id_producto = p.id_producto
                GROUP BY dv.id_producto
                ORDER BY total_vendido DESC
                LIMIT ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $limite, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }
}
?>