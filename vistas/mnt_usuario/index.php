<?php 
require_once("../auth.php"); 
if($_SESSION["rol"] == "empleado") {
    header("Location: ../mnt_inicio");
    exit();
}
$titulo_pagina = 'Gestión de Usuarios';
require_once("../menu.php"); 
?>

<button class="btn btn-custom-primary mb-3" id="btn_nuevo_usuario">
    <i class="fas fa-plus"></i> Nuevo Usuario
</button>

<div class="table-responsive">
    <table id="tabla-usuarios" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
                <?php
                    if($_SESSION["rol"] == "admin") {
                        ?>
                        <th>EDITAR</th>
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

<?php require_once("modal_usuario.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="mnt_usuario.js"></script>

</div>
</div>
</body>
</html>