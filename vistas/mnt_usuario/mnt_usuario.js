var tabla_usuarios;

$(document).ready(function () {
    // Inicializar DataTable
    tabla_usuarios = $('#tabla-usuarios').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../../controladores/UsuarioControlador.php?opc=listar',
            type: "get",
            dataType: "json",
            error: function (e) { console.log(e.responseText); }
        },
        "bDestroy": true,
        "responsive": true,
        "iDisplayLength": 10,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sSearch": "Buscar:"
        }
    }).DataTable();

    // Nuevo usuario
    $("#btn_nuevo_usuario").click(function () {
        $("#id_usuario").val("");
        $("#nombre_usuario").val("");
        $("#contrasena").val("");
        $("#rol").val("empleado");
        $("#pass_help").show();
        $("#modalUsuarioLabel").html("Registrar Usuario");
        $("#modalUsuario").modal('show');
    });

    // Guardar usuario
    $("#btn_guardar_usuario").click(function () {
        let id_usuario = $("#id_usuario").val();
        let nombre_usuario = $("#nombre_usuario").val();
        let contrasena = $("#contrasena").val();
        let rol = $("#rol").val();

        if (nombre_usuario === "") {
            Swal.fire('Error', 'Ingrese un nombre de usuario', 'error');
            return;
        }

        if (id_usuario === "" && contrasena === "") {
            Swal.fire('Error', 'Ingrese una contraseña', 'error');
            return;
        }

        let datos = {
            id_usuario: id_usuario,
            nombre_usuario: nombre_usuario,
            contrasena: contrasena,
            rol: rol
        };

        $.ajax({
            url: "../../controladores/UsuarioControlador.php?opc=guardar_editar",
            type: "POST",
            data: datos,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    $("#modalUsuario").modal('hide');
                    tabla_usuarios.ajax.reload();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Error al guardar', 'error');
            }
        });
    });
});

function editar(id_usuario) {
    $.post("../../controladores/UsuarioControlador.php?opc=mostrar",
        { id_usuario: id_usuario }, function (data) {
            let usuario = JSON.parse(data);
            if (usuario) {
                $("#id_usuario").val(usuario.id_usuario);
                $("#nombre_usuario").val(usuario.nombre_usuario);
                $("#contrasena").val("");
                $("#rol").val(usuario.rol);
                $("#pass_help").show();
                $("#modalUsuarioLabel").html("Editar Usuario");
                $("#modalUsuario").modal('show');
            }
        });
}

function eliminar(id_usuario) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controladores/UsuarioControlador.php?opc=eliminar",
                { id_usuario: id_usuario }, function (response) {
                    let res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire('Eliminado', 'Usuario eliminado', 'success');
                        tabla_usuarios.ajax.reload();
                    } else {
                        Swal.fire('Error', 'No se pudo eliminar', 'error');
                    }
                });
        }
    });
}