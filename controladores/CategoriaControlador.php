<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Categoria.php");


    $categoria = new Categoria();


    switch($_GET["opc"]) {
        case "listar":
            $datos=$categoria->get_categoria();
            $data=Array();

            foreach($datos as $dato) {
                $mini_array = array();

                $mini_array[] = $dato["id_categoria"];  
                $mini_array[] = $dato["nombre_categoria"];                
                $mini_array[] = '<button type="button" onClick="editar('.$dato["id_categoria"].');" id="'.$dato["id_categoria"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>'; 
                $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_categoria"].');" id="'.$dato["id_categoria"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa-solid fa-delete-left"></i></div></button>'; 
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
            $datos=$categoria->get_categoria_id($_POST["id_categoria"]);

            if(empty($_POST["id_categoria"])) {
                if(is_array($datos)==true and count($datos)==0) {
                    $categoria -> insert_categoria($_POST["nombre_categoria"]);
                }
            } else {
                $categoria -> update_categoria($_POST["id_categoria"], $_POST["nombre_categoria"]);
            }
            break;
        case "mostrar":
            $datos=$categoria->get_categoria_id($_POST["id_categoria"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $otp = array();
                foreach($datos as $dato) {
                    $otp["id_categoria"] = $dato["id_categoria"];
                    $otp["nombre_categoria"] = $dato["nombre_categoria"];
                }
                echo json_encode($otp);
            }       
            break;
        case "eliminar":
            $categoria -> delete_categoria_id($_POST["id_categoria"]);
            break;   
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
    }
?>
