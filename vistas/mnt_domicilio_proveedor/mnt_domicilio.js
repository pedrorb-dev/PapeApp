var tabla;

function init(){
    $("#domicilio-form").on("submit",function(e){
        guardaryeditar(e);	
    });
}

$(document).ready(function(){

    tabla=$('#tabla-domicilios').dataTable({
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
            url: '../../controladores/DomicilioProveedorControlador.php?opc=listar',
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
    var formData = new FormData($("#domicilio-form")[0]);
    $.ajax({
        url: "../../controladores/DomicilioProveedorControlador.php?opc=guardar_editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        error: function(e){
                console.log(e.responseText);	
        },
        success: function(datos){
            console.log(datos)
            $('#domicilio-form')[0].reset();
            $("#modalmant").modal('hide');
            $('#tabla-domicilios').DataTable().ajax.reload();

            swal.fire(
                'Registro!',
                'El registro correctamente.',
                'success'
            )
        }
    });
}

function editar(id_domicilio_proveedor){
    $.post("../../controladores/DomicilioProveedorControlador.php?opc=mostrar",{id_domicilio_proveedor: id_domicilio_proveedor},function (data) {
        console.log(data);
        data = JSON.parse(data);
        $('#id_domicilio_proveedor').val(data.id_domicilio_proveedor);
        $('#calle').val(data.calle);
        $('#ciudad').val(data.ciudad);
        $('#numero').val(data.numero);
        $('#colonia').val(data.colonia);
        $('#codigo_postal').val(data.codigo_postal);
    });
    $('#modal-titulo').html('Editar Registro');
    $('#modalmant').modal('show');
}

function eliminar(id_domicilio_proveedor){
    console.log(id_domicilio_proveedor);
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
            $.post("../../controladores/DomicilioProveedorControlador.php?opc=eliminar",{id_domicilio_proveedor:id_domicilio_proveedor},function (data) {
                $('#tabla-domicilios').DataTable().ajax.reload();	    
            });
            swal.fire(
                'Eliminado!',
                'El registro se elimino correctamente.',
                'success'
            )
        }
    })
}

$(document).on("click","#add_dom", function(){
    $('#id_domicilio_proveedor').val("");
    $('#calle').val("");
    $('#ciudad').val("");
    $('#numero').val("");
    $('#colonia').val("");
    $('#codigo_postal').val("");

    $('#modal-titulo').html('Agregar Registro');
    $('#modalmant').modal('show');
    
});

init();