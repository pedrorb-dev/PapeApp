<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Pedido.php");
    require_once("../modelos/Proveedor.php");
    require_once("../modelos/Producto.php");


    $pedido = new Pedido();
    $producto = new Producto();
    $proveedor = new Proveedor();


    switch($_GET["opc"]) {
        case "listar":
            $datos=$pedido->get_detalles_pedido_pendiente();
            $data=Array();

            foreach($datos as $dato) {
                $mini_array = array();
                $mini_array[] = $dato["nombre_producto"];
                $mini_array[] = $dato["cantidad"];
                $mini_array[] = $dato["costo"];
                $mini_array[] = $dato["subtotal"];
                $mini_array[] = '<button type="button" onClick="editar('.$dato["id_detalle_pedido"].');" 
                class="btn btn-outline-primary btn-icon">
                <div><i class="fa fa-edit"></i></div>
                </button>';
                $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_detalle_pedido"].');" 
                class="btn btn-outline-danger btn-icon">
                <div><i class="fa-solid fa-delete-left"></i></div>
                </button>';
                $data[] = $mini_array;
            }

            $respuesta = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($respuesta);

            break;
        case "guardar_editar":
            $datos=$pedido->get_pedido_id($_POST["id_pedido"]);

            if(empty($_POST["id_pedido"])) {
                if(is_array($datos)==true and count($datos)==0) { #los pedidos se van a separar por proveedor
                    $pedido -> insert_pedido($_POST["id_proveedor"], $_POST["estado"]);
                }
            } else {
                $pedido -> update_pedido($_POST["id_pedido"], $_POST["estado"]);
            }
            break;
        case "mostrar":
            $datos=$pedido->get_pedido_id($_POST["id_pedido"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $otp = array();
                foreach($datos as $dato) {
                    $otp["id_pedido"] = $dato["id_pedido"];
                    $otp["id_proveedor"] = $dato["id_proveedor"];
                    $otp["fecha_pedido"] = $dato["fecha_pedido"];
                    $otp["estado"] = $dato["estado"];
                }
                echo json_encode($otp);
            }

            
            break;
        case "eliminar":
            $pedido -> delete_pedido($_POST["id_pedido"]);
            break;    
    }
?>
