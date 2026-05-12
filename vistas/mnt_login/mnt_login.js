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
            let msj = document.getElementById("msj_error2");
            if (datos !== "") {
                msj.innerText = datos; //para meter el mensaje de respuesta al <p>
                msj.style.display = "block"; // mostrar
            } else {
                msj.style.display = "none";
            }
            $('#forma-registro')[0].reset();
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
            console.log(respuesta);

            let msj = document.getElementById("msj_error");

            if (respuesta.trim() === "ok") {
                msj.style.display = "none";
                window.location.href = "/PapeApp/vistas/mnt_inicio";
            } else {
                msj.innerText = respuesta; //para meter el mensaje de respuesta al <p>
                msj.style.display = "block"; // mostrar
            }
        }
    });
}
init();