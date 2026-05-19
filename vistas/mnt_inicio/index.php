    <?php 
        require_once("../auth.php");
        $titulo_pagina = 'Bienvenido'; 
        require_once("../menu.php"); 
        require_once("../../controladores/ProductoControlador.php");
    $producto = new Producto();

    $bajo_stock = $producto->get_productos_bajo_stock();
    $total_productos = $producto-> get_total_productos();
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <title>Inicio</title>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .pedidos{
            height: 100%;
            width: 70%;
            margin-left: auto;
            background-color: rgb(58, 166, 161);
            display: flex;
            flex-direction: column;
            margin-right: 20px;
            border-radius: 10px;
        }
        .elemento{
            height: 190px;
            margin: auto;
            background-color: rgb(179, 232, 232);
            width: 90%;
            border-radius: 20px;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items:center;
            font-weight: bold;
        }

        .elemento img{
            width: 100px;
        }

        .elemento div{
            margin: 22px;
        }

        .elemento img.box{
            width: 130px;
            height: auto;
        }

        .elemento:hover{
            transform: scale(1.04);
            box-shadow: 5px 5px 10px rgba(60, 108, 108, 0.3);
        }

        .elemento p{
            color: red;
        }

        .div button:hover{
            cursor: pointer;
        }
    
    </style>
</head>
<body>
    <div class="row">
    <div class="col-md-6">
        <div class="chart-card">
            <h4> Top 10 Productos Más Vendidos</h4>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Fecha Inicio</label>
                    <input type="date" id="top_fecha_inicio" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Fecha Fin</label>
                    <input type="date" id="top_fecha_fin" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary mt-4" id="btn_filtrar_top">
                         Filtrar
                    </button>
                </div>
                <div class="col-md-4">
                    <!--<button class="btn btn-secondary mt-4" id="btn_limpiar_top">
                        <i class="fas fa-undo-alt"></i> Limpiar Filtro
                    </button>-->
                </div>
            </div>
            <canvas id="topProductosChart" height="300"></canvas>
            
        </div>
    </div>
     <div class="col-md-6">
        <div class="pedidos">
            <div class="elemento consulta">
                <div>
                    Productos bajos en stock:
                    <p>
                     <?php
                        echo $bajo_stock["total"];
                        ?>
                        </p>
                        <button type="submit" class="btn btn-primary" id="btn_bajo_stock">Ver productos</button>
                    
                </div>
                <div>
                    <img src="img/warning2.png" alt="imagen warning">
                </div>
            </div>
            <div class="elemento">
                <div>
                    Cantidad total de productos:
                    <h2>
                        <?php
                        echo $total_productos["total_productos"];
                        ?>
                    </h2>
                </div>
                <div>
                    <img src="img/box.png" alt="imagen warning" class = "box">
                </div>
            </div>
            <div class="elemento">
                <div>
                    Productos vendidos
                </div>
                <div>
                    <img src="img/shopping_bag.png" alt="imagen warning" class = "box">
                </div>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="mnt_inicio.js"></script>
<?php require_once("modal_faltantes.php")?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
</body>
</html>