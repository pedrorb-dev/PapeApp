let topProductosChart;

$(document).ready(function () {
    // Establecer fechas por defecto (últimos 30 días) para el filtro
    let hoy = new Date().toISOString().split('T')[0];
    let hace30Dias = new Date();
    hace30Dias.setDate(hace30Dias.getDate() - 30);
    let fechaDefaultInicio = hace30Dias.toISOString().split('T')[0];

    $("#top_fecha_inicio").val(fechaDefaultInicio);
    $("#top_fecha_fin").val(hoy);

    // Cargar gráfico inicial
    cargarTopProductos();

    // Evento filtrar
    $("#btn_filtrar_top").click(function () {
        cargarTopProductos();
    });

    // Evento limpiar filtro (quitar fechas y recargar todo el período)
    $("#btn_limpiar_top").click(function () {
        $("#top_fecha_inicio").val('');
        $("#top_fecha_fin").val('');
        cargarTopProductos();
    });

    $("#btn_bajo_stock").click(function(){
    $("#modalBajoStock").modal("show");
});

$.post("../../controladores/ProductoControlador.php?opc=mostrar_faltantes", function (data) {
    });

    tabla = $('#tabla-faltantes').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../../controladores/ProductoControlador.php?opc=mostrar_faltantes',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,//Por cada 10 registros hace una paginación
        "order": [[0, "asc"]],//Ordenar (columna,orden)
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
});



function cargarTopProductos() {
    let fecha_inicio = $("#top_fecha_inicio").val();
    let fecha_fin = $("#top_fecha_fin").val();

    let datos = { limite: 10 };
    if (fecha_inicio && fecha_fin) {
        datos.fecha_inicio = fecha_inicio;
        datos.fecha_fin = fecha_fin;
    }

    $.ajax({

        url: "../../controladores/ReporteControlador.php?opc=top_productos",
        type: "POST",
        data: datos,
        dataType: "json",
        success: function (productos) {
            const backgroundColor = ["rgb(53, 137, 171)", "rgb(118, 171, 53)", "rgb(227, 48, 175)", "rgb(149, 43, 224)", "rgb(224, 130, 43)", "rgb(7, 130, 12)"]
            let nombres = productos.map(p => p.nombre_producto);
            let vendidos = productos.map(p => parseInt(p.total_vendido));

            if (topProductosChart) topProductosChart.destroy();

            let ctx = document.getElementById('topProductosChart').getContext('2d');
            topProductosChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: nombres,
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: vendidos,
                        backgroundColor: backgroundColor,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'x',
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        },
        error: function () {
            Swal.fire('Error', 'No se pudieron cargar los datos', 'error');
        }
    });
}

