<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Compra.php");


    $compra = new Compra();


    switch($_GET["opc"]) {
        case "listar":
            $datos=$compra->get_compra();
            $data=Array();

            foreach($datos as $dato) {
                $mini_array = array();

                $mini_array[] = $dato["id_compra"];  
                $mini_array[] = $dato["id_proveedor"];  #viene del join
                $mini_array[] = $dato["nombre_proveedor"];  
                $mini_array[] = $dato["fecha_compra"]; 
                $mini_array[] = $dato["total_compra"];            
                $mini_array[] = '<button type="button" onClick="editar('.$dato["id_compra"].');" id="'.$dato["id_compra"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>'; 
                $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_compra"].');" id="'.$dato["id_compra"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa-solid fa-delete-left"></i></div></button>'; 
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
            $datos=$compra->get_compra_id($_POST["id_compra"]);
            if(empty($_POST["id_compra"])) {
                if(is_array($datos)==true and count($datos)==0) {         #el total de la compra si se inserta
                    $compra -> insert_compra($_POST["id_proveedor"], $_POST["total_compra"]);
                }
            } else {
                $compra -> update_compra($_POST["id_proveedor"], $_POST["total_compra"], $_POST["id_compra"] );
            }
            break;
        case "mostrar":
            $datos=$compra->get_compra_id($_POST["id_compra"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $otp = array();
                foreach($datos as $dato) {
                    $otp["id_compra"] = $dato["id_compra"];
                    $otp["id_proveedor"] = $dato["id_proveedor"]; #mostrar tambien el nombre del proveedor
                    $otp["nombre_proveedor"] = $dato["nombre_proveedor"]; 
                    $otp["fecha_compra"] = $dato["fecha_compra"];
                    $otp["total_compra"] = $dato["total_compra"];
                }
                echo json_encode($otp);
            }       
            break;
        case "eliminar":
            $compra -> delete_compra($_POST["id_categoria"]);
            break;   
            /*
        case "combo":
            $datos = $categoria->get_categoria();
            if(is_array($datos) == true and count($datos) > 0) {
                $html = "<option label='Seleccione una categoria'></option>";
                foreach($datos as $dato) {
                    $html .= "<option value='".$dato["id_categoria"]."'>".$dato["nombre_categoria"]."</option>";
                }
                echo $html;
            }    
            break;
            */
    }
?>
