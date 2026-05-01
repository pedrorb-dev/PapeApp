var tabla;

function init() {
    $("#forma-registro").on("submit", function (e) {
        guardaryeditar(e);
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

        }
    });
}

init();