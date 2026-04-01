var tabla;

function init(){
    $("#producto-form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

$(document).ready(function(){
    $.post("../../controladores/CategoriaControlador.php?opc=combo",function (data) {
        $("#id_categoria").html(data);
    });

    tabla=$('#tabla-productos').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
        "ajax":{
            url: '../../controladores/ProductoControlador.php?opc=listar',
            type : "get",
            dataType : "json",
            error: function(e){
                console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"responsive": true,
		"bInfo":true,
		"iDisplayLength": 10,//Por cada 10 registros hace una paginación
	    "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	    "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
		}
	}).DataTable();
});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#producto-form")[0]);
    $.ajax({
        url: "../../controladores/ProductoControlador.php?opc=guardar_editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        error: function(e){
                console.log(e.responseText);	
        },
        success: function(datos){

            $('#producto-form')[0].reset();
            $("#modalmant").modal('hide');
            $('#tabla-productos').DataTable().ajax.reload();

            swal.fire(
                'Registro!',
                'El registro correctamente.',
                'success'
            )
        }
    });
}

function editar(id_producto){
    $.post("../../controladores/ProductoControlador.php?opc=mostrar",{id_producto:id_producto},function (data) {
        data = JSON.parse(data);
        $('#id_producto').val(data.id_producto);
        $('#id_categoria').val(data.id_categoria).trigger('change');
        $('#nombre_producto').val(data.nombre_producto);
        $('#descripcion').val(data.descripcion);
        $('#precio').val(data.precio);
        $('#costo').val(data.costo);
        $('#marca').val(data.marca);
        $('#min_stock').val(data.min_stock);
        $('#stock').val(data.stock);
    });
    $('#modal-titulo').html('Editar Registro');
    $('#modalmant').modal('show');
}

function eliminar(id_producto){
    swal.fire({
        title: 'CRUD',
        text: "Desea Eliminar el Registro?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controladores/ProductoControlador.php?opc=eliminar",{id_producto:id_producto},function (data) {
                $('#tabla-productos').DataTable().ajax.reload();	    
            });

            

            swal.fire(
                'Eliminado!',
                'El registro se elimino correctamente.',
                'success'
            )
        }
    })
}

$(document).on("click","#add_prod", function(){
    $('#id_producto').val("");
        $('#id_categoria').val("").trigger('change');
        $('#nombre_producto').val("");
        $('#descripcion').val("");
        $('#precio').val("");
        $('#costo').val("");
        $('#marca').val("");
        $('#min_stock').val("");
        $('#stock').val("");

    $('#modal-titulo').html('Agregar Registro');
    $('#modalmant').modal('show');
});

init();