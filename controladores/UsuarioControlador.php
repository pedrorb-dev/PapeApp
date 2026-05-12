<?php
require_once("../config/Conexion.php");
require_once("../modelos/Usuarios.php");

$usuario = new Usuarios();

switch($_GET["opc"]) {
    #esto es SOLO para insertar en la base de datos
    case "guardaryeditar": 
        if (empty($_POST["usuario"]) || empty($_POST["contraseña"])) {
            echo("Introduzca valores en los campos");
        } else {
            $datos = $usuario -> get_usuario_name($_POST["usuario"]);
            
            if(count($datos) != 0) {
                echo("No puede haber valores repetidos");
            } else {
                $usuario->insert_usuario(
                    $_POST["usuario"],
                    $_POST["contraseña"],
                    "empleado"
                );
            }

        }
    break;

    case "iniciarsesion":

    if (empty($_POST["usuario"]) || empty($_POST["contraseña"])) {
        echo("Introduzca valores en los campos");
    } else {

        $datos = $usuario->login(
            $_POST["usuario"],
            $_POST["contraseña"]
        );

        if ($datos) {
             // Iniciar sesión
            session_start();    
            $_SESSION["id_usuario"] = $datos["id_usuario"];
            $_SESSION["nombre_usuario"] = $datos["nombre_usuario"];
            $_SESSION["rol"] = $datos["rol"];
            echo "ok";
            //header("Location: ../mnt_inicio/index.php");
            exit(); 
        } else {
            echo("Verifica que tus datos estén bien");
        }
    }
    break;
    case "listar":
            $datos = $usuario -> get_usuario();
            $dato = Array(); //está siendo declarado
            foreach($datos as $data) {
                $sub_arreglo = array();
                $sub_arreglo[] = $data["id_usuario"]; //columna tras columna depende la tabla
                $sub_arreglo[] = $data["nombre_usuario"];
                $sub_arreglo[] = $data["rol"];
                $sub_arreglo[] = '<button type="button" onClick="editar('.$data["id_usuario"].');" id="'.$data["id_usuario"].'" class="btn btn-outline-primary btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_arreglo[] = '<button type="button" onClick="eliminar('.$data["id_usuario"].');" id="'.$data["id_usuario"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-delete-left"></i></div></button>';
                $dato[] = $sub_arreglo;
            }

            $respuesta = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($dato),
                "iTotalDisplayRecords"=>count($dato),
                "aaData"=>$dato);
            echo json_encode($respuesta);

            break;
        case "guardar_editar":
            $datos = $usuario -> get_usuario_id($_POST["id_usuario"]);
            if(empty($_POST["id_usuario"])) {
                //if(is_array($datos)==true and count($datos)==0) {
                    $usuario -> insert_usuario($_POST["nombre_usuario"], $_POST["contrasena"], $_POST["rol"]);
                //}
            } else {
                $usuario -> update_usuario($_POST["id_usuario"], $_POST["nombre_usuario"],$_POST["contrasena"], $_POST["rol"]);
            }
            break;
        case "mostrar":
            $datos = $usuario -> get_usuario_id($_POST["id_usuario"]);
            if(is_array($datos)==true and count($datos) > 0) {
                $sub_arreglo = Array();
                foreach($datos as $dato) {
                    $sub_arreglo["id_usuario"] = $dato["id_usuario"]; //columna tras columna depende la tabla
                    $sub_arreglo["nombre_usuario"] = $dato["nombre_usuario"];
                    $sub_arreglo["rol"] = $dato["rol"];
                }
                echo json_encode($sub_arreglo);
            }
            break;
        case "eliminar":
            $usuario->delete_usuario($_POST["id_usuario"]);
            break;
        
}

?>