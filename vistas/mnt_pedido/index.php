<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        #btn_faltantes {
            margin-left: 30px;
            height: 45px;
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        #btn_faltantes:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(159, 135, 40, 0.3);
        }

        .input-cantidad {
            width: 80px;
            border-radius: 5px;
        }

        .btn_estado{
            margin-bottom: 10px;
            border-radius: 10px;
            height: 45px;
            margin-top: 15px;
        }
    </style>

</head>

<body>
    <?php require_once("../auth.php");
    $titulo_pagina = 'Pedidos';
    require_once("../menu.php"); ?>
    <div class="container">
        <button class="btn btn-custom-primary mb-4" id="add_prod">
            <i class="fas fa-plus"></i> Agregar producto
        </button>

        <button class="btn btn-warning mb-4" id="btn_faltantes">
            <i class="fa-solid fa-triangle-exclamation"></i> Consulta productos en bajo stock
        </button>
        <div class="container">

    <!-- ENCABEZADO DEL PEDIDO -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

        <!-- INFORMACIÓN DEL PEDIDO -->
        <div>
            <h3 class="mb-3">Pedido actual</h3>

            <p class="mb-1">
                <strong>Fecha del pedido:</strong>
                24/05/2026
            </p>

            <p class="mb-3">
                <strong>Estado:</strong>
                <span class="badge bg-warning text-dark">
                    Pendiente
                </span>
            </p>
        </div>
         <div class="d-flex gap-2 mt-3 mt-md-0">

            <button type="button" class="btn btn-success">
                <i class="fa-solid fa-check"></i>
                Marcar como completado
            </button>

            <button type="button" class="btn btn-danger">
                <i class="fa-solid fa-trash"></i>
                Vaciar pedido
            </button>

        </div>

        <div class="table-responsive">

        <table id="tabla-productos"
               class="table table-striped table-bordered"
               style="width:100%">

            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>COSTO UNITARIO</th>
                    <th>SUBTOTAL</th>
                    <th>EDITAR</th>

                    <?php
                    if($_SESSION["rol"] == "admin"){
                    ?>
                        <th>ELIMINAR</th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>

            <tbody>
            </tbody>

        </table>

    </div>

</div>
    </div>
    <?php require_once("modal_faltantes.php") ?>
    <?php require_once("modal_pedido.php") ?>
    <?php require_once("modal_detalle_pedido.php") ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="mnt_pedido.js"></script>
</body>

</html>