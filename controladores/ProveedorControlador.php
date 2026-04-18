<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Proveedor.php");

    $proveedor = new Proveedor();

    switch($_GET["opc"]) {
        case "listar":
            #similar sino lo mismo que proveedor.get_proveedor()
            $datos = $proveedor -> get_proveedor();
            $dato = Array(); //está siendo declarado
            foreach($datos as $data) {
                $sub_arreglo = array();
                $sub_arreglo[] = $data["id_proveedor"]; //columna tras columna depende la tabla
                $sub_arreglo[] = $data["nombre_proveedor"];
                $sub_arreglo[] = $data["correo"];
                $sub_arreglo[] = $data["telefono_1"];
                $sub_arreglo[] = $data["telefono_2"];
                $sub_arreglo[] = $data["RFC"];
                $sub_arreglo[] = '<button type="button" onClick="editar('.$data["id_proveedor"].');" id="'.$data["id_proveedor"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_arreglo[] = '<button type="button" onClick="eliminar('.$data["id_proveedor"].');" id="'.$data["id_proveedor"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-delete-left"></i></div></button>';
                $dato[] = $sub_arreglo;
            }

            $respuesta = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($dato),
                "iTotalDisplayRecords"=>count($dato),
                "aaData"=>$dato);
            echo json_encode($respuesta);

            break;
        case "guardaryeditar":
            $datos = $proveedor -> get_proveedor_id($_POST["id_proveedor"]);
            if(empty($_POST["id_proveedor"])) {
                //if(is_array($datos)==true and count($datos)==0) {
                    $proveedor -> insert_proveedor($_POST["nombre_proveedor"], $_POST["correo"], $_POST["telefono_1"], $_POST["telefono_2"], $_POST["RFC"]);
                //}
            } else {
                $proveedor -> update_proveedor($_POST["id_proveedor"], $_POST["nombre_proveedor"],$_POST["correo"], $_POST["telefono_1"], $_POST["telefono_2"], $_POST["RFC"]);
            }
            break;
        case "mostrar":
            $datos = $proveedor -> get_proveedor_id($_POST["id_proveedor"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $sub_arreglo = Array();
                foreach($datos as $dato) {
                    $sub_arreglo["id_proveedor"] = $dato["id_proveedor"]; //columna tras columna depende la tabla
                    $sub_arreglo["nombre_proveedor"] = $dato["nombre_proveedor"];
                    $sub_arreglo["correo"] = $dato["correo"];
                    $sub_arreglo["telefono_1"] = $dato["telefono_1"];
                    $sub_arreglo["telefono_2"] = $dato["telefono_2"];
                    $sub_arreglo["RFC"] = $dato["RFC"];
                }
                echo json_encode($sub_arreglo);
            }
            break;
        case "eliminar":
            $proveedor->delete_proveedor($_POST["id_proveedor"]);
            break;
        case "combo":
            $datos = $proveedor->get_proveedor();
            if(is_array($datos) == true and count($datos) > 0) {
                $html = "<option label='Seleccione un proveedor'></option>";
                foreach($datos as $dato) {
                    $html .= "<option value='".$dato["id_proveedor"]."'>".$dato["nombre_proveedor"]."</option>";
                }
                echo $html;
            }    
            break;
    }
?>