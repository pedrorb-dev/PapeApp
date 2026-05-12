<?php
session_start();
require_once("../config/Conexion.php");
require_once("../modelos/Reporte.php");

$reporte = new Reporte();

switch($_GET["opc"]) {
    case "top_productos":
        $limite = $_POST["limite"] ?? 10;
        $datos = $reporte->get_top_productos($limite);
        echo json_encode($datos);
        break;
}
?>