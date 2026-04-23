<?php

require_once("../config/Conexion.php");
require_once("../modelos/Usuarios.php");

$usuario = new Usuarios();


switch($_GET["opc"]) {
        case "listar":
            #similar sino lo mismo que proveedor.get_proveedor()
            $datos = $usuario -> get_usuario();
            $dato = Array(); //está siendo declarado
            foreach($datos as $data) {
                $sub_arreglo = array();
                $sub_arreglo[] = $data["id_usuario"]; //columna tras columna depende la tabla
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
                if(!empty($_POST["ingresar"])){
                    if (empty($_POST["usuario"]) and empty($_POST["contraseña"])  ) {
                         echo("Introduzca valores en los campos")
                } else {
                    # code...
                }
    
                }           
            break;



?>