$(document).ready(function () {

    $('#btnEnviar').on('click', function () {

        var url = "../Controlador/calculo_fecha_pps_controlador.php?op=fecha";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formulario").serialize(),
            success: function (data) {
                $("#fecha_finalizacion").val(data);

            }
        });
    });
});


