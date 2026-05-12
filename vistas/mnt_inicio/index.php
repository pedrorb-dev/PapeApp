<?php 
$titulo_pagina = 'Dashboard - Papelería';
require_once("../menu.php"); 
?>
<link rel="stylesheet" href="styles.css">

<div class="row">    
    <div class="col-md-6">
        <div class="chart-card">
            <h5><i class="fas fa-trophy"></i> Productos Más Vendidos</h5>
            <canvas id="top_productos_chart" height="300"></canvas>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="mnt_inicio.js"></script>

</div>
</div>
</body>
</html>