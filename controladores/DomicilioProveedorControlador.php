<?php
    require_once("../config/Conexion.php"); #importar la conexion
    require_once("../modelos/Domicilio_proveedor.php"); #importar el modelo


    $direccion = new Domicilio_proveedor(); #objeto de la clase de domicilio porveedor


    switch($_GET["opc"]) { 
        case "listar": #para hacer una consulta en general de todos los elementos de la tabla
            $datos=$direccion->get_domicilio_proveedor();  #para obtener la informacion que regresa el metodo
            $data=Array();  

            foreach($datos as $dato) {  
                $mini_array = array();

                $mini_array[] = $dato["id_domicilio_proveedor"];  
                $mini_array[] = $dato["calle"];    
                $mini_array[] = $dato["ciudad"];    
                $mini_array[] = $dato["numero"];   
                $mini_array[] = $dato["colonia"];             
                $mini_array[] = $dato["codigo_postal"];        
                $mini_array[] = '<button type="button" onClick="editar('.$dato["id_domicilio_proveedor"].');" id="'.$dato["id_domicilio_proveedor"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>'; 
                $mini_array[] = '<button type="button" onClick="eliminar('.$dato["id_domicilio_proveedor"].');" id="'.$dato["id_domicilio_proveedor"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa-solid fa-delete-left"></i></div></button>'; 
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
            $datos=$direccion->get_domicilio_proveedor_id($_POST["id_domicilio_proveedor"]);

            if(empty($_POST["id_domicilio_proveedor"])) {
                if(is_array($datos)==true and count($datos)==0) {
                    $direccion -> insert_domicilio_proveedor($_POST["calle"], $_POST["ciudad"], $_POST["numero"], $_POST["colonia"], $_POST["codigo_postal"]);
                }
            } else {
                $direccion -> update_domicilio_proveedor($_POST["id_domicilio_proveedor"], $_POST["calle"], $_POST["ciudad"], $_POST["numero"], $_POST["colonia"], $_POST["codigo_postal"]);
            }
            break;
        case "mostrar":
            $datos=$direccion->get_domicilio_proveedor_id($_POST["id_domicilio_proveedor"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $otp = array();
                foreach($datos as $dato) {
                    $otp["id_domicilio_proveedor"] = $dato["id_domicilio_proveedor"];
                    $otp["calle"] = $dato["calle"];
                    $otp["ciudad"] = $dato["ciudad"];
                    $otp["numero"] = $dato["numero"];
                    $otp["colonia"] = $dato["colonia"];
                    $otp["codigo_postal"] = $dato["codigo_postal"];
                }
                echo json_encode($otp);
            }       
            break;
        case "eliminar":
            $direccion -> delete_domicilio_proveedor($_POST["id_domicilio_proveedor"]);
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
            break;*/
    }
?>
