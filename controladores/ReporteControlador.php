<?php
    require_once("../config/Conexion.php");
    require_once("../modelos/Reporte.php");

    $reporte = new Reporte();

    switch($_GET["opc"]) {
        case "top_productos":
        $limite = $_POST["limite"] ?? 10;
        $fecha_inicio = $_POST["fecha_inicio"] ?? null;
        $fecha_fin = $_POST["fecha_fin"] ?? null;
        
        if ($fecha_inicio && $fecha_fin) {
            $datos = $reporte->get_top_productos($limite, $fecha_inicio, $fecha_fin);
        } else {
            $datos = $reporte->get_top_productos($limite);
        }
        echo json_encode($datos);
        break;
    }
?>