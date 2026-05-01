<?php
require_once("../config/Conexion.php");
require_once("../modelos/Compra.php");
require_once("../modelos/Producto.php");
require_once("../modelos/Proveedor.php");

$compra = new Compra();
$producto = new Producto();
$proveedor = new Proveedor();

switch($_GET["opc"]) {
    
    case "listar":
        $datos = $compra->get_compras();
        $data = array();
        
        foreach($datos as $dato) {
            $mini_array = array();
            $mini_array[] = $dato["id_compra"];
            $mini_array[] = $dato["fecha_compra"];
            $mini_array[] = $dato["nombre_proveedor"];
            $mini_array[] = "$" . number_format($dato["total_compra"], 2);
            $mini_array[] = $dato["num_productos"];
            $mini_array[] = '<button type="button" onClick="editar('.$dato["id_compra"].');" class="btn btn-outline-warning btn-icon"><i class="fa fa-edit"></i></button>';
            $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_compra"].');" class="btn btn-outline-danger btn-icon"><i class="fa fa-trash"></i></button>';
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
        $id_proveedor = $_POST["id_proveedor"];
        $fecha_compra = date('Y-m-d H:i:s');
        $total_compra = $_POST["total_compra"];
        $detalles = json_decode($_POST["detalles"], true);
        
        $resultado = $compra->insert_compra($id_proveedor, $fecha_compra, $total_compra, $detalles);
        echo json_encode(array("success" => true, "id_compra" => $resultado));
        break;
    
    case "mostrar":
        $datos = $compra->get_compra_id($_POST["id_compra"]);
        echo json_encode($datos);
        break;
    
    case "eliminar":
        $compra->delete_compra_id($_POST["id_compra"]);
        echo json_encode(array("success" => true));
        break;
    
    case "listar_proveedores":
        $datos = $proveedor->get_proveedor();
        $html = "<option value=''>Seleccione un proveedor</option>";
        foreach($datos as $dato) {
            $html .= "<option value='{$dato['id_proveedor']}'>{$dato['nombre_proveedor']}</option>";
        }
        echo $html;
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
                    "costo" => $dato["costo"],
                    "precio" => $dato["precio"],
                    "stock" => $dato["stock"],
                    "marca" => $dato["marca"]
                );
            }
        }
        echo json_encode($resultados);
        break;
    case "actualizar":
        $id_compra = $_POST["id_compra"];
        $id_proveedor = $_POST["id_proveedor"];
        $detalles = json_decode($_POST["detalles"], true);
        
        $resultado = $compra->update_compra($id_compra, $id_proveedor, $detalles);
        echo json_encode(array("success" => $resultado));
        break;

    case "obtener_para_editar":
        $id_compra = $_POST["id_compra"];
        $datos = $compra->get_compra_with_details($id_compra);
        echo json_encode($datos);
        break;
}
?>