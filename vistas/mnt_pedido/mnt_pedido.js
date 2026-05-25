$(document).ready(function () {
     let tabla_detalles = $('#tabla-productos').DataTable({

        "aProcessing": true,
        "aServerSide": true,

        "ajax": {
            url: '../../controladores/PedidoControlador.php?opc=listar',
            type: 'GET',
            dataType: 'json',

            error: function (e) {
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "iDisplayLength": 10,

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sSearch": "Buscar:",

            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });


    // Inicializar DataTable UNA sola vez
    let tabla = $('#tabla-faltantes').DataTable({

        "aProcessing": true,
        "aServerSide": true,

        dom: 'Bfrtip',

        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],

        "ajax": {
            url: '../../controladores/ProductoControlador.php?opc=mostrar_faltantes',
            type: "GET",
            dataType: "json",

            error: function (e) {
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]],

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",

            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

    let tabla_pedido = $('#tabla-productos').DataTable({

        "ajax": {
            url: '../../controladores/PedidoControlador.php?opc=listar_detalles',
            type: 'GET',
            dataType: 'json',

            error: function (e) {
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "iDisplayLength": 10,

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sSearch": "Buscar:"
        }
    });

    // Abrir modal
    $("#btn_faltantes").click(function () {

        // Recargar datos de la tabla
        tabla.ajax.reload();

        // Mostrar modal con Bootstrap 5
        let modal = new bootstrap.Modal(
            document.getElementById('modalBajoStock')
        );

        modal.show();
    });

     $("#add_prod").click(function () {

        let modal = new bootstrap.Modal(
            document.getElementById('modalPedido')
        );

        modal.show();
    });



});

function agregar_a_pedido(id_producto) {

    // Obtener input de cantidad
    let cantidad = $("#cantidad_" + id_producto).val();

    // Validación simple
    if (cantidad <= 0 || cantidad === "") {

        Swal.fire(
            'Error',
            'Ingrese una cantidad válida',
            'error'
        );

        return;
    }

    // AJAX
    $.ajax({

        url: '../../controladores/PedidoControlador.php?opc=agregar_detalle',

        type: 'POST',

        data: {
            id_producto: id_producto,
            cantidad: cantidad
        },

        success: function (response) {

            let res = JSON.parse(response);

            if (res.success) {

                Swal.fire(
                    'Éxito',
                    'Producto agregado al pedido',
                    'success'
                );

                // Recargar tabla principal
                $('#tabla-productos').DataTable().ajax.reload();

            } else {

                Swal.fire(
                    'Error',
                    res.message,
                    'error'
                );
            }
        },

        error: function (e) {

            console.log(e.responseText);

            Swal.fire(
                'Error',
                'Ocurrió un error',
                'error'
            );
        }

    });
}