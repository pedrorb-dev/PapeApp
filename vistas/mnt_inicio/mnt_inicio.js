
// Variables para los gráficos
let ventasChart, topProductosChart, categoriasChart;

// Función para recargar TODOS los datos
function recargarTodosLosDatos() {
    cargarTopProductos();
}

$(document).ready(function () {
    let hoy = new Date().toISOString().split('T')[0];
    let hace30Dias = new Date();
    hace30Dias.setDate(hace30Dias.getDate() - 30);

    $("#fecha_inicio").val(hace30Dias.toISOString().split('T')[0]);
    $("#fecha_fin").val(hoy);

    recargarTodosLosDatos();

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            recargarTodosLosDatos();
        }
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            recargarTodosLosDatos();
        }
    });

    setInterval(function () {
        recargarTodosLosDatos();
    }, 30000);

    $("#btn_actualizar").click(function () {
        recargarTodosLosDatos();
    });
});


function cargarTopProductos() {
    $.ajax({
        url: "../../controladores/ReporteControlador.php?opc=top_productos",
        type: "POST",
        data: { limite: 8 },
        dataType: "json",
        success: function (productos) {
            let nombres = productos.map(p => p.nombre_producto);
            let vendidos = productos.map(p => parseInt(p.total_vendido));

            if (topProductosChart) topProductosChart.destroy();

            let ctx = document.getElementById('top_productos_chart').getContext('2d');
            topProductosChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombres,
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: vendidos,
                        backgroundColor: 'rgb(50, 113, 121)',
                        borderRadius: 8,
                        barPercentage: 0.7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'x',
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => `${ctx.raw} unidades`
                            }
                        }
                    }
                }
            });
        },
        error: function () {
            console.log("Error cargando los productos");
        }
    });
}

