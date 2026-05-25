<?php
class Pedido extends Conexion {

    // listar pedidos
    public function get_pedido()
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT p.id_pedido,
                       p.fecha_pedido,
                       p.estado,
                       COUNT(dp.id_detalle_pedido) as num_productos
                FROM pedido p
                LEFT JOIN detalle_pedido dp
                    ON p.id_pedido = dp.id_pedido
                GROUP BY p.id_pedido
                ORDER BY p.id_pedido DESC";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $sql->fetchAll();
    }

    //obtener pedido por id
    public function get_pedido_id($id_pedido)
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT pe.*,
                       dp.id_detalle_pedido,
                       dp.id_producto,
                       dp.cantidad,
                       p.nombre_producto,
                       p.marca
                FROM pedido pe
                LEFT JOIN detalle_pedido dp
                    ON pe.id_pedido = dp.id_pedido
                LEFT JOIN productos p
                    ON dp.id_producto = p.id_producto
                WHERE pe.id_pedido = ?";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_pedido);
        $sql->execute();

        return $sql->fetchAll();
    }

    // OBTENER PEDIDO PENDIENTE
    public function get_pedido_pendiente()
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT *
                FROM pedido
                WHERE estado = 'pendiente'
                LIMIT 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $sql->fetch();
    }

    // crear un pedido pendiente
    
    public function crear_pedido_pendiente()
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "INSERT INTO pedido
                (id_pedido, fecha_pedido, estado)
                VALUES
                (NULL, NOW(), 'pendiente')";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $conectar->lastInsertId();
    }

    //agregar nuevos productos al pedido pendiente
    public function agregar_detalle_pedido($id_producto, $cantidad)
    {
        $conectar = parent::conectar();
        parent::set_names();

        try {

            $conectar->beginTransaction();

            //buscar si hay un pedido pendiente
            $pedido = $this->get_pedido_pendiente();

            // SI NO EXISTE, CREARLO
            if(!$pedido){

                $id_pedido = $this->crear_pedido_pendiente();

            } else {

                $id_pedido = $pedido["id_pedido"];
            }

            //obtener el costo del producto
            $sqlProducto = "SELECT costo
                            FROM productos
                            WHERE id_producto = ?";

            $sqlProducto = $conectar->prepare($sqlProducto);
            $sqlProducto->bindValue(1, $id_producto);
            $sqlProducto->execute();

            $producto = $sqlProducto->fetch();

            $costo = $producto["costo"];

            //comprobar si ya existe
            $sqlExiste = "SELECT *
                          FROM detalle_pedido
                          WHERE id_pedido = ?
                          AND id_producto = ?";

            $sqlExiste = $conectar->prepare($sqlExiste);
            $sqlExiste->bindValue(1, $id_pedido);
            $sqlExiste->bindValue(2, $id_producto);
            $sqlExiste->execute();

            $detalle = $sqlExiste->fetch();

            //si ya existe sumar a la cantidad
            if($detalle){

                $sqlUpdate = "UPDATE detalle_pedido
                              SET cantidad = cantidad + ?
                              WHERE id_detalle_pedido = ?";

                $sqlUpdate = $conectar->prepare($sqlUpdate);
                $sqlUpdate->bindValue(1, $cantidad);
                $sqlUpdate->bindValue(2, $detalle["id_detalle_pedido"]);
                $sqlUpdate->execute();

            } else {

                //insertar un nuevo detalle en caso de que aun no esté pedido
                $sqlInsert = "INSERT INTO detalle_pedido
                             (id_detalle_pedido,
                              id_pedido,
                              id_producto,
                              cantidad)
                              VALUES
                              (NULL, ?, ?, ?)";

                $sqlInsert = $conectar->prepare($sqlInsert);
                $sqlInsert->bindValue(1, $id_pedido);
                $sqlInsert->bindValue(2, $id_producto);
                $sqlInsert->bindValue(3, $cantidad);
                $sqlInsert->execute();
            }

            $conectar->commit();

            return true;

        } catch(Exception $e){

            $conectar->rollBack();
            echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);

            return false;
        }
    }

    // ELIMINAR PEDIDO
    public function delete_pedido($id_pedido)
    {
        $conectar = parent::conectar();
        parent::set_names();

        try {

            $conectar->beginTransaction();

            // Eliminar detalles
            $sql2 = "DELETE FROM detalle_pedido
                     WHERE id_pedido = ?";

            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindValue(1, $id_pedido);
            $stmt2->execute();

            // Eliminar pedido
            $sql3 = "DELETE FROM pedido
                     WHERE id_pedido = ?";

            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindValue(1, $id_pedido);
            $stmt3->execute();

            $conectar->commit();

        } catch(Exception $e){

            $conectar->rollBack();
            throw $e;
        }
    }

    // ACTUALIZAR ESTADO
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

        } catch(Exception $e){

            $conectar->rollBack();
        }
    }

    public function eliminar_detalle_pedido($id_detalle_pedido)
    {
        $conectar = parent::conectar();
        parent::set_names();

        try {

            $sql = "DELETE FROM detalle_pedido
                WHERE id_detalle_pedido = ?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detalle_pedido);
            $sql->execute();

            return true;

        } catch (Exception $e) {

            return false;
        }
    }

    // OBTENER DETALLES DEL PEDIDO PENDIENTE

    public function get_detalles_pedido_pendiente()
    {
        $conectar = parent::conectar();
        parent::set_names();

        $sql = "SELECT 
                dp.id_detalle_pedido,
                dp.id_producto,
                p.nombre_producto,
                p.costo,
                dp.cantidad,
                (dp.cantidad * p.costo) AS subtotal
            FROM detalle_pedido dp

            INNER JOIN pedido pe
                ON dp.id_pedido = pe.id_pedido

            INNER JOIN productos p
                ON dp.id_producto = p.id_producto

            WHERE pe.estado = 'pendiente'";

        $sql = $conectar->prepare($sql);
        $sql->execute();

        return $sql->fetchAll();
    }

    public function update_detalle_pedido($id_detalle_pedido, $cantidad)
{
    $conectar = parent::conectar();
    parent::set_names();

    $sql = "UPDATE detalle_pedido
            SET cantidad = ?
            WHERE id_detalle_pedido = ?";

    $sql = $conectar->prepare($sql);

    $sql->bindValue(1, $cantidad);
    $sql->bindValue(2, $id_detalle_pedido);

    $sql->execute();
}
}


?>