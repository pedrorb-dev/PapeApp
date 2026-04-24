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
            $usuario->insert_usuario(
                $_POST["usuario"],
                $_POST["contraseña"],
                "empleado"
            );
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
            echo("Login correcto");
        } else {
            echo("Verifica que tus datos estén bien");
        }
    }
    break;

}

?>