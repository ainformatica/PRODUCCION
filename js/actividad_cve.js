var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	listar1();
	listar2();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#nombre_ambito").val("");
	$("#descripcion_ambito").val("");
	$("#id_ambito").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#listadoregistros1").hide();
		$("#listadoregistros2").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#listadoregistros1").show();
		$("#listadoregistros2").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
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
		},
	    dom: 'fBlrtip',//Definimos los elementos del control de tabla Bfrtilp
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/actividad_cve_controlador.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función Listar
function listar1()
{
	tabla=$('#tbllistado1').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
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
		},
	    dom: 'fBlrtip',//Definimos los elementos del control de tabla Bfrtilp
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/actividad_cve_controlador.php?op=listar1',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
function listar2()
{
	tabla=$('#tbllistado2').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
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
		},
	    dom: 'fBlrtip',//Definimos los elementos del control de tabla Bfrtilp
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/actividad_cve_controlador.php?op=listar2',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
 
	$.ajax({
		url: "../Controlador/actividad_cve_controlador.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {     
	                   
	       swal({
		
		        title: datos,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
             mostrarform(false);
             tabla.ajax.reload();
			
	    }

	});
	limpiar();
}

function mostrar(id_actividad_voae, tipo=0)
{
	$('.form-control').prop( "disabled", false );
	$('#btnGuardar').show();
	if (tipo==1) {
		$('.form-control').prop( "disabled", true );
		$('#btnGuardar').hide();
	}

	$.post("../Controlador/actividad_cve_controlador.php?op=mostrar",{id_actividad_voae : id_actividad_voae}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#no_solicitud").val(data.no_solicitud);
		$("#nombre_actividad").val(data.nombre_actividad);
 		$("#ubicacion").val(data.ubicacion);
 		$("#fch_inicial_actividad").val(data.fch_inicial_actividad);
		$("#fch_final_actividad").val(data.fch_final_actividad);
 		$("#descripcion").val(data.descripcion);
 		$("#poblacion_objetivo").val(data.poblacion_objetivo);
		$("#presupuesto").val(data.presupuesto);
		$("#staff_alumnos").val(data.staff_alumnos);
		$("#observaciones").val(data.observaciones);
		$("#id_ambito").val(data.id_ambito);
		$("#periodo").val(data.periodo);
 		$("#id_actividad_voae").val(data.id_actividad_voae);

 	})
}

/*swal({
	            title: "",
				text:"Estado Activado",	
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 2000
          	});/**/
//Función para desactivar registros
function denegar(id_actividad_voae)
{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de Denegar esta Actividad?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/actividad_cve_controlador.php?op=denegar", {id_actividad_voae : id_actividad_voae}, function(e){
        		swal({
		
		        title: e,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
			tabla.ajax.reload();

        	});	
			
		} 
	})
	
}


//Función para Finalizar Actividad
function finalizar(id_actividad_voae)


{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de Finalizar esta Actividad?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/actividad_cve_controlador.php?op=finalizar", {id_actividad_voae : id_actividad_voae}, function(e){
        		swal({
		
		        title: e,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
			tabla.ajax.reload();

        	});	
			
		} 
	})
	
}


function solicitado(id_actividad_voae)

{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de Enviar esta Actividad para Aprobacion?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/actividad_cve_controlador.php?op=solicitado", {id_actividad_voae : id_actividad_voae}, function(e){
        		swal({
		
		        title: e,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
			tabla.ajax.reload();

        	});	
			
		} 
	})
	
}


//Función para activar registros
function aprobar(id_actividad_voae)

{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de Aprobar esta Actividad?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/actividad_cve_controlador.php?op=aprobar", {id_actividad_voae : id_actividad_voae}, function(e){
        		swal({
		
		        title: e,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
			tabla.ajax.reload();

        	});	
			
		} 
	})
	
}

init();

