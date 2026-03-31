var tabla;

function init(){
    $("#categoria-form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

$(document).ready(function(){

    tabla=$('#tabla-categorias').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5',
		            'pdf'
		        ],
        "ajax":{
            url: '../../controladores/CategoriaControlador.php?opc=listar',
            type : "get",
            dataType : "json",
            error: function(xhr) {
                console.log("ERROR:", xhr.responseText);
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
    var formData = new FormData($("#categoria-form")[0]);
    $.ajax({
        url: "../../controladores/CategoriaControlador.php?opc=guardar_editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        error: function(xhr) {
                console.log("ERROR:", xhr.responseText);
            },
        success: function(datos){

            $('#categoria-form')[0].reset();
            $("#modalmant").modal('hide');
            $('#tabla-categorias').DataTable().ajax.reload();

            swal.fire(
                'Registro!',
                'El registro correctamente.',
                'success'
            )
        }
    });
}

function editar(id_categoria){
    $.post("../../controladores/CategoriaControlador.php?opc=mostrar",{id_categoria:id_categoria},function (data) {
        data = JSON.parse(data);
        $('#id_categoria').val(data.id_categoria);
        $('#nombre_categoria').val(data.nombre_categoria);
    });
    $('#modal-titulo').html('Editar Registro');
    $('#modalmant').modal('show');
}

function eliminar(id_categoria){
    Swal.fire({
        title: 'CRUD',
        text: "Desea Eliminar el Registro?",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../../controladores/CategoriaControlador.php?opc=eliminar",{id_categoria:id_categoria},function (data) {
                $('#tabla-categorias').DataTable().ajax.reload();	

            Swal.fire(
                'Eliminado!',
                'El registro se elimino correctamente.',
                'success'
            )
            });

            
        }
    })
}

$(document).on("click","#add_cat", function(){
    $('#id_categoria').val('');
    $('#nombre_categoria').val('');

    $('#modal-titulo').html('Nuevo Registro');
    $('#modalmant').modal('show');
    $('#categoria-form')[0].reset();
});

init();