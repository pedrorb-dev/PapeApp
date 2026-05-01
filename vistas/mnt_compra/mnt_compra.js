var carrito = [];
var tabla_compras;

$(document).ready(function () {
    // Cargar proveedores
    $.post("../../controladores/CompraControlador.php?opc=listar_proveedores", function (data) {
        $("#id_proveedor").html(data);
    });

    // Inicializar DataTable
    tabla_compras = $('#tabla-compras').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../../controladores/CompraControlador.php?opc=listar',
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

    // Nueva compra
    $("#btn_nueva_compra").click(function () {
        carrito = [];
        actualizar_carrito();
        $("#id_proveedor").val("");
        $("#id_compra_edit").val("");  // Limpiar campo de edición
        $("#modalCompraLabel").html("Registrar Compra");  // Resetear título
        $("#buscar_producto").val("");  // Limpiar búsqueda
        $("#resultados_busqueda").html("");  // Limpiar resultados
        $("#modalCompra").modal('show');
    });

    // Búsqueda de productos
    var timeout;
    $("#buscar_producto").keyup(function () {
        clearTimeout(timeout);
        let buscar = $(this).val();
        if (buscar.length >= 2) {
            timeout = setTimeout(function () {
                $.post("../../controladores/CompraControlador.php?opc=buscar_productos",
                    { buscar: buscar }, function (data) {
                        let productos = JSON.parse(data);
                        let html = "";
                        if (productos.length > 0) {
                            productos.forEach(prod => {
                                html += `<a href="#" class="list-group-item list-group-item-action" 
                                            onclick="agregar_al_carrito(${prod.id_producto}, '${prod.nombre_producto}', ${prod.costo})">
                                            <strong>${prod.nombre_producto}</strong> - $${prod.costo} 
                                            <small class="text-muted">(Stock actual: ${prod.stock} | Precio venta: $${prod.precio})</small>
                                        </a>`;
                            });
                        } else {
                            html = '<div class="list-group-item text-muted">No se encontraron productos</div>';
                        }
                        $("#resultados_busqueda").html(html);
                    });
            }, 300);
        } else {
            $("#resultados_busqueda").html("");
        }
    });

    // Guardar/Actualizar compra (UN SOLO EVENTO)
    $("#btn_guardar_compra").click(function () {
        let id_compra = $("#id_compra_edit").val();
        let id_proveedor = $("#id_proveedor").val();

        if (id_proveedor === "") {
            Swal.fire('Error', 'Seleccione un proveedor', 'error');
            return;
        }

        if (carrito.length === 0) {
            Swal.fire('Error', 'Agregue al menos un producto', 'error');
            return;
        }

        let total_compra = calcular_total();
        let datos = {
            id_proveedor: id_proveedor,
            total_compra: total_compra,
            detalles: JSON.stringify(carrito)
        };

        // Determinar si es guardar o actualizar
        let url = "../../controladores/CompraControlador.php?opc=guardar";
        let mensaje = 'Compra registrada correctamente';

        if (id_compra && id_compra !== "") {
            datos.id_compra = id_compra;
            url = "../../controladores/CompraControlador.php?opc=actualizar";
            mensaje = 'Compra actualizada correctamente';
        }

        $.ajax({
            url: url,
            type: "POST",
            data: datos,
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    Swal.fire('Éxito', mensaje, 'success');
                    $("#modalCompra").modal('hide');
                    $("#buscar_producto").val('');
                    $("#resultados_busqueda").html('');
                    $("#id_compra_edit").val('');
                    $("#modalCompraLabel").html("Registrar Compra");
                    $("#id_proveedor").val("");
                    carrito = [];
                    actualizar_carrito();
                    tabla_compras.ajax.reload();
                } else {
                    Swal.fire('Error', 'Error al procesar la compra', 'error');
                }
            },
            error: function (e) {
                console.log(e.responseText);
                Swal.fire('Error', 'Error al procesar la compra', 'error');
            }
        });
    });
});

// Función para editar compra
function editar(id_compra) {
    $.post("../../controladores/CompraControlador.php?opc=obtener_para_editar",
        { id_compra: id_compra }, function (data) {
            let compra = JSON.parse(data);

            if (compra && compra.detalles) {
                // Limpiar carrito actual
                carrito = [];

                // Cargar proveedor
                $("#id_proveedor").val(compra.id_proveedor);

                // Cargar productos del carrito
                compra.detalles.forEach(det => {
                    carrito.push({
                        id_producto: det.id_producto,
                        nombre_producto: det.nombre_producto,
                        cantidad: det.cantidad,
                        costo_unitario: parseFloat(det.costo_unitario),
                        subtotal: det.cantidad * parseFloat(det.costo_unitario)
                    });
                });

                // Actualizar vista del carrito
                actualizar_carrito();

                // Guardar ID de compra en el campo hidden
                $("#id_compra_edit").val(compra.id_compra);

                // Cambiar título del modal
                $("#modalCompraLabel").html("Editar Compra");

                // Limpiar búsqueda
                $("#buscar_producto").val("");
                $("#resultados_busqueda").html("");

                // Mostrar modal
                $("#modalCompra").modal('show');
            } else {
                Swal.fire('Error', 'No se pudo cargar la compra', 'error');
            }
        });
}

function agregar_al_carrito(id, nombre, costo) {
    let existe = carrito.find(item => item.id_producto === id);
    if (existe) {
        existe.cantidad++;
        existe.subtotal = existe.cantidad * existe.costo_unitario;
    } else {
        carrito.push({
            id_producto: id,
            nombre_producto: nombre,
            cantidad: 1,
            costo_unitario: costo,
            subtotal: costo
        });
    }
    actualizar_carrito();
    $("#buscar_producto").val('');
    $("#resultados_busqueda").html('');
}

function actualizar_carrito() {
    let html = "";
    if (carrito.length === 0) {
        html = `<tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="fa fa-info-circle"></i> No hay productos agregados
                    </td>
                </tr>`;
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
                          <td>$${parseFloat(item.costo_unitario).toFixed(2)}</td>
                          <td>$${parseFloat(item.subtotal).toFixed(2)}</td>
                          <td>
                              <button class="btn btn-danger btn-sm" onclick="eliminar_del_carrito(${index})">
                                  <i class="fa fa-trash"></i>
                              </button>
                          </td>
                      </tr>`;
        });
    }
    $("#carrito_body").html(html);
    $("#total_compra").html("$" + calcular_total().toFixed(2));
}

function calcular_total() {
    let total = 0;
    carrito.forEach(item => total += item.subtotal);
    return total;
}

function actualizar_cantidad(index, nueva_cantidad) {
    nueva_cantidad = parseInt(nueva_cantidad);
    if (isNaN(nueva_cantidad) || nueva_cantidad <= 0) {
        eliminar_del_carrito(index);
    } else {
        carrito[index].cantidad = nueva_cantidad;
        carrito[index].subtotal = carrito[index].cantidad * carrito[index].costo_unitario;
        actualizar_carrito();
    }
}

function eliminar_del_carrito(index) {
    carrito.splice(index, 1);
    actualizar_carrito();
}

function ver_detalle(id_compra) {
    $.post("../../controladores/CompraControlador.php?opc=mostrar",
        { id_compra: id_compra }, function (data) {
            let detalles = JSON.parse(data);
            if (detalles.length > 0) {
                let html = `<h5><strong>Proveedor:</strong> ${detalles[0].nombre_proveedor}</h5>
                            <h6><strong>Fecha:</strong> ${detalles[0].fecha_compra}</h6>
                            <table class="table table-bordered mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Marca</th>
                                        <th>Cantidad</th>
                                        <th>Costo Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                let total = 0;
                detalles.forEach(det => {
                    if (det.id_producto) {
                        let subtotal = det.cantidad * parseFloat(det.costo_unitario);
                        html += `<tr>
                                      <td>${det.nombre_producto}</td>
                                      <td>${det.marca || '-'}</td>
                                      <td>${det.cantidad}</td>
                                      <td>$${parseFloat(det.costo_unitario).toFixed(2)}</td>
                                      <td>$${subtotal.toFixed(2)}</td>
                                  </tr>`;
                        total += subtotal;
                    }
                });
                html += `</tbody>
                         <tfoot class="table-secondary">
                              <tr class="fw-bold">
                                  <th colspan="4" class="text-end">TOTAL</th>
                                  <th>$${total.toFixed(2)}</th>
                              </tr>
                         </tfoot>
                         </table>`;
                $("#detalle_compra_content").html(html);
                $("#modalDetalleCompra").modal('show');
            } else {
                Swal.fire('Error', 'No se encontraron detalles', 'error');
            }
        });
}

function eliminar(id_compra) {
    Swal.fire({
        title: '¿Eliminar compra?',
        text: "Esta acción revertirá el stock",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controladores/CompraControlador.php?opc=eliminar",
                { id_compra: id_compra }, function () {
                    tabla_compras.ajax.reload();
                    Swal.fire('Eliminado', 'Compra eliminada correctamente', 'success');
                });
        }
    });
}