<?php

require_once("../config/Conexion.php");
require_once("../modelos/Usuarios.php");

$usuario = new Usuarios();

if(!empty($_POST["ingresar"])){
    if (empty($_POST["usuario"]) and empty($_POST["contraseña"])  ) {
        echo("Introduzca valores en los campos")
    } else {
        # code...
    }
    
}

?>