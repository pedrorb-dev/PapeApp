var tabla;

function init() {
    $("#forma-registro").on("submit", function (e) {
        guardaryeditar(e);
    });
    
    $("#forma").on("submit", function (e) {
        ingresar(e);
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#forma-registro")[0]);
    $.ajax({
        url: "../../controladores/UsuarioControlador.php?opc=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $('#forma-registro')[0].reset();
           // $("#modalmant").modal('hide');
           // $('#tabla-categorias').DataTable().ajax.reload();

            /*swal.fire(
                'Registro!',
                'El registro correctamente.',
                'success'
            )*/
        }
    });
}

function ingresar(e) {
    e.preventDefault();
    var formData = new FormData($("#forma")[0]);
    $.ajax({
        url: "../../controladores/UsuarioControlador.php?opc=iniciarsesion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log("RESPUESTA:", respuesta);
            if (respuesta.trim() === "ok") {
                window.location.href = "/PapeApp/vistas/index.php";
            } else {
                swal.fire("Error", respuesta, "error");
            }

            /*swal.fire(
                'Registro!',
                'El registro correctamente.',
                'success'
            )*/
        }
    });
}
init();