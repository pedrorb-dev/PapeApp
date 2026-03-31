<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Producto.php");


    $producto = new Producto();


    switch($_GET["opc"]) {
        case "listar":
            $datos=$producto->get_producto();
            $data=Array();

            foreach($datos as $dato) {
                $mini_array = array();
                $mini_array[] = $dato["id_producto"];
                $mini_array[] = $dato["id_categoria"];
                $mini_array[] = $dato["nombre_producto"];
                $mini_array[] = $dato["descripcion"];
                $mini_array[] = $dato["precio"];
                $mini_array[] = $dato["costo"];
                $mini_array[] = $dato["marca"];
                $mini_array[] = $dato["min_stock"];
                $mini_array[] = $dato["stock"];
                $mini_array[] = '<button type="button" onClick="editar('.$dato["id_producto"].');" id="'.$dato["id_producto"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>'; 
                $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_producto"].');" id="'.$dato["id_producto"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa-solid fa-delete-left"></i></div></button>'; 
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
            $datos=$producto->get_producto_id($_POST["id_producto"]);

            if(empty($_POST["id_producto"])) {
                if(is_array($datos)==true and count($datos)==0) {
                    $producto -> insert_producto($_POST["id_categoria"], $_POST["nombre_producto"], $_POST["descripcion"], $_POST["precio"], $_POST["costo"], $_POST["marca"], $_POST["min_stock"], $_POST["stock"]);
                }
            } else {
                $producto -> update_producto($_POST["id_producto"], $_POST["id_categoria"], $_POST["nombre_producto"], $_POST["descripcion"], $_POST["precio"], $_POST["costo"], $_POST["marca"], $_POST["min_stock"], $_POST["stock"]);
            }
            break;
        case "mostrar":
            $datos=$producto->get_producto_id($_POST["id_producto"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $otp = array();
                foreach($datos as $dato) {
                    $otp["id_producto"] = $dato["id_producto"];
                    $otp["id_categoria"] = $dato["id_categoria"];
                    $otp["nombre_producto"] = $dato["nombre_producto"];
                    $otp["descripcion"] = $dato["descripcion"];
                    $otp["precio"] = $dato["precio"];
                    $otp["costo"] = $dato["costo"];
                    $otp["marca"] = $dato["marca"];
                    $otp["min_stock"] = $dato["min_stock"];
                    $otp["stock"] = $dato["stock"];
                }
                echo json_encode($otp);
            }

            
            break;
        case "eliminar":
            $producto -> delete_producto_id($_POST["id_producto"]);
            break;    
    }
?>
