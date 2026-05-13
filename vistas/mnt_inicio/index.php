    <?php 
        require_once("../auth.php");
        $titulo_pagina = 'Bienvenido'; 
        require_once("../menu.php"); 
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <title>Inicio</title>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="mnt_inicio.js"></script>
</body>
</html>