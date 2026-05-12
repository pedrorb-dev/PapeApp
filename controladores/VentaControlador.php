<?php
require_once("../config/Conexion.php");
require_once("../modelos/Venta.php");
require_once("../modelos/Producto.php");

$venta = new Venta();
$producto = new Producto();

switch($_GET["opc"]) {
    
    case "listar":
        $datos = $venta->get_ventas();
        $data = array();
        
        foreach($datos as $dato) {
            $mini_array = array();
            $mini_array[] = $dato["id_venta"];
            $mini_array[] = $dato["fecha_venta"];
            //darle el formato $500.00 ($ con el total y 2 puntos decimales)
            $mini_array[] = "$" . number_format($dato["total_venta"], 2);
            $mini_array[] = $dato["num_productos"];
            $mini_array[] = '<button type="button" onClick="editar_venta('.$dato["id_venta"].');" class="btn btn-outline-warning btn-icon"><i class="fa fa-edit"></i></button>';
            $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_venta"].');" class="btn btn-outline-danger btn-icon"><i class="fa fa-trash"></i></button>';
            $data[] = $mini_array;
        }
        
        $respuesta = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data
        );
        echo json_encode($respuesta);
        break;
    
    case "guardar":
        $fecha_venta = date('Y-m-d H:i:s');
        $total_venta = $_POST["total_venta"];
        $detalles = json_decode($_POST["detalles"], true);
        
        $resultado = $venta->insert_venta($fecha_venta, $total_venta, $detalles);
        echo json_encode(array("success" => true, "id_venta" => $resultado));
        break;
    
    case "mostrar":
        $datos = $venta->get_venta_id($_POST["id_venta"]);
        echo json_encode($datos);
        break;
    
    case "eliminar":
        $venta->delete_venta_id($_POST["id_venta"]);
        echo json_encode(array("success" => true));
        break;
    case "actualizar":
        $id_venta = $_POST["id_venta"];
        $total_venta = $_POST["total_venta"];
        $detalles = json_decode($_POST["detalles"], true);

        // Primero eliminar la venta original (revirtiendo stock)
        $venta->delete_venta_id($id_venta);
        // Luego insertar la nueva venta
        $nuevo_id = $venta->insert_venta(date('Y-m-d H:i:s'), $total_venta, $detalles);
        echo json_encode(array("success" => true, "id_venta" => $nuevo_id));
        break;
    case "buscar_productos":
        $buscar = $_POST["buscar"];
        $datos = $producto->get_producto();
        $resultados = array();
        
        foreach($datos as $dato) {
            if(stripos($dato["nombre_producto"], $buscar) !== false || 
               stripos($dato["marca"], $buscar) !== false) {
                $resultados[] = array(
                    "id_producto" => $dato["id_producto"],
                    "nombre_producto" => $dato["nombre_producto"],
                    "precio" => $dato["precio"],
                    "stock" => $dato["stock"],
                    "marca" => $dato["marca"]
                );
            }
        }
        echo json_encode($resultados);
        break;
}
?>