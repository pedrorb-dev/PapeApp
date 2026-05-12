var carrito = [];
var tabla_ventas;

$(document).ready(function () {
    // Inicializar DataTable
    tabla_ventas = $('#tabla-ventas').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../../controladores/VentaControlador.php?opc=listar',
            type: "get",
            dataType: "json",
            error: function (e) { console.log(e.responseText); }
        },
        "bDestroy": true,
        "responsive": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    }).DataTable();

    // Nueva venta
    $("#btn_nueva_venta").click(function () {
        $("#modalVentaLabel").html("Registrar Venta");
        $("#id_venta_edit").val("");
        carrito = [];
        actualizar_carrito();
        $("#buscar_producto").val('');
        $("#resultados_busqueda").html('');
        $("#modalVenta").modal('show');
    });

    // Búsqueda de productos
    $("#buscar_producto").keyup(function () {
        let buscar = $(this).val();
        if (buscar.length >= 2) {
            $.post("../../controladores/VentaControlador.php?opc=buscar_productos",
                { buscar: buscar }, function (data) {
                    let productos = JSON.parse(data);
                    let html = "";
                    productos.forEach(prod => {
                        html += `<a href="#" class="list-group-item list-group-item-action" 
                                    onclick="agregar_al_carrito(${prod.id_producto}, '${prod.nombre_producto}', ${prod.precio})">
                                    ${prod.nombre_producto} - $${prod.precio} (Stock: ${prod.stock})
                                </a>`;
                    });
                    $("#resultados_busqueda").html(html);
                });
        }
    });

    // Guardar venta (NUEVA o EDITADA)
    $("#btn_guardar_venta").click(function () {
        let id_venta = $("#id_venta_edit").val();

        if (carrito.length === 0) {
            Swal.fire('Error', 'Agregue al menos un producto', 'error');
            return;
        }

        let total_venta = calcular_total();
        let datos = {
            total_venta: total_venta,
            detalles: JSON.stringify(carrito)
        };

        let url = "../../controladores/VentaControlador.php?opc=guardar";
        let mensaje = 'Venta registrada correctamente';

        // Si es edición, enviar id y usar opc=actualizar
        if (id_venta && id_venta !== "") {
            datos.id_venta = id_venta;
            url = "../../controladores/VentaControlador.php?opc=actualizar";
            mensaje = 'Venta actualizada correctamente';
        }

        $.ajax({
            url: url,
            type: "POST",
            data: datos,
            success: function (response) {
                let res = JSON.parse(response);
                if (res.success) {
                    Swal.fire('Éxito', mensaje, 'success');
                    $("#modalVenta").modal('hide');
                    $("#buscar_producto").val('');
                    $("#resultados_busqueda").html('');
                    $("#id_venta_edit").val('');
                    $("#modalVentaLabel").html("Registrar Venta");
                    carrito = [];
                    actualizar_carrito();
                    tabla_ventas.ajax.reload();
                }
            },
            error: function (e) {
                console.log(e.responseText);
                Swal.fire('Error', 'Error al guardar la venta', 'error');
            }
        });
    });
});

// ========== FUNCIONES DEL CARRITO ==========

function agregar_al_carrito(id, nombre, precio, cantidad = 1) {
    let existe = carrito.find(item => item.id_producto === id);

    if (existe) {
        existe.cantidad += cantidad;
        existe.subtotal = existe.cantidad * existe.precio_unitario;
    } else {
        carrito.push({
            id_producto: id,
            nombre_producto: nombre,
            cantidad: cantidad,
            precio_unitario: precio,
            subtotal: precio * cantidad
        });
    }
    actualizar_carrito();
    $("#buscar_producto").val('');
    $("#resultados_busqueda").html('');
}

function actualizar_carrito() {
    let html = "";
    if (carrito.length === 0) {
        html = `<tr><td colspan="5" class="text-center text-muted">No hay productos agregados</td></tr>`;
    } else {
        carrito.forEach((item, index) => {
            html += `<tr>
                        <td>${item.nombre_producto}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm" 
                                   value="${item.cantidad}" 
                                   onchange="actualizar_cantidad(${index}, this.value)"
                                   style="width: 70px" min="1">
                        </td>
                        <td>$${item.precio_unitario}</td>
                        <td>$${item.subtotal}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminar_del_carrito(${index})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
        });
    }
    $("#carrito_body").html(html);
    $("#total_venta").html("$" + calcular_total());
}

function calcular_total() {
    let total = 0;
    carrito.forEach(item => total += item.subtotal);
    return total;
}

function actualizar_cantidad(index, nueva_cantidad) {
    if (nueva_cantidad <= 0) {
        eliminar_del_carrito(index);
    } else {
        carrito[index].cantidad = parseInt(nueva_cantidad);
        carrito[index].subtotal = carrito[index].cantidad * carrito[index].precio_unitario;
        actualizar_carrito();
    }
}

function eliminar_del_carrito(index) {
    carrito.splice(index, 1);
    actualizar_carrito();
}

function editar_venta(id_venta) {
    // Solo cargar datos, NO eliminar
    $.post("../../controladores/VentaControlador.php?opc=mostrar",
        { id_venta: id_venta }, function (data) {
            let detalles = JSON.parse(data);

            // Limpiar carrito
            carrito = [];

            // Cargar productos al carrito
            detalles.forEach(det => {
                if (det.id_producto) {
                    agregar_al_carrito(
                        det.id_producto,
                        det.nombre_producto,
                        parseFloat(det.precio_unitario),
                        parseInt(det.cantidad)
                    );
                }
            });

            // Guardar ID para usarlo al guardar
            $("#id_venta_edit").val(id_venta);
            $("#modalVentaLabel").html("Editar Venta");
            $("#modalVenta").modal('show');
        });
}

function eliminar(id_venta) {
    Swal.fire({
        title: '¿Eliminar venta?',
        text: "Esta acción revertirá el stock",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controladores/VentaControlador.php?opc=eliminar",
                { id_venta: id_venta }, function () {
                    tabla_ventas.ajax.reload();
                    Swal.fire('Eliminado', 'Venta eliminada correctamente', 'success');
                });
        }
    });
}