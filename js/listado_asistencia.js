var hoy = new Date();
fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
fechaYHora = fecha + ' ' + hora;
var tabla;
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })

    $("#form_import").on("submit", function(e) {
        importar(e);
    })
}

//Función limpiar
function limpiar() {

    $("#id_asistencia").val("");
    $("#cuenta").val("");
    $("#nombre_alumno").val("");
    $("#carrera").val("");
    $("#cant_horas").val("");
    $("#file-input").val("");
    $("#id_cuenta2").val("");


}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#form_import").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#btnlistado").hide();
        $("#btnpdf").hide();
        $("#btn_enviar").hide();
        $("#file-input").hide();


    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#form_import").show();
        $("#btnagregar").show();
        $("#btnlistado").show();
        $("#btnpdf").show();
        $("#btn_enviar").show();
        $("#file-input").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

///Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
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
        dom: 'fBlrtip', //Definimos los elementos del control de tabla Bfrtilp
        buttons: [],
        "ajax": {
            url: '../Controlador/listado_asistencia_controlador.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        "iDisplayLength": 5, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}


//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../Controlador/listado_asistencia_controlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {

            swal({

                title: datos,
                text: " ",
                icon: "info",
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

function importar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btn_enviar").prop("disabled", false);
    var formData = new FormData($("#form_import")[0]);

    $.ajax({
        url: "../Controlador/listado_asistencia_controlador.php?op=importar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {

            swal({

                title: datos,
                text: " ",
                icon: "info",
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

function mostrar(id_asistencia) {
    $.post("../Controlador/listado_asistencia_controlador.php?op=mostrar", { id_asistencia: id_asistencia }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#id_asistencia").val(data.id_asistencia);
        $("#cuenta").val(data.cuenta);
        $("#nombre_alumno").val(data.nombre_alumno);
        $("#carrera").val(data.carrera);
        $("#cant_horas").val(data.cant_horas);
        $("#id_cuenta2").val(data.cuenta);

    })
}



function eliminar(id_asistencia) {
    swal({
        title: "Alerta",
        text: "¿Está seguro de eliminar al estudiante de la lista?",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    }).then((result) => {
        if (result) {

            $.post("../Controlador/listado_asistencia_controlador.php?op=eliminar", { id_asistencia: id_asistencia }, function(e) {
                swal({

                    title: e,
                    text: " ",
                    icon: "success",
                    buttons: false,
                    dangerMode: false,
                    timer: 4000,
                });
                tabla.ajax.reload();
            });

        }
    })
}
init();