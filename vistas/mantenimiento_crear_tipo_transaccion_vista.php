<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 12197;


$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento_laboratorio";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_tipotransaccion'] = "";
    } else {
        $_SESSION['btn_guardar_tipotransaccion'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        if ($msj == 1) {
            echo '<script> alert("Lo sentimos la transacción a ingresar ya existe favor intenta con uno nuevo")</script>';
        }

        if ($msj == 2) {
            echo '<script> alert("Transacción agregada correctamente")</script>';
        }
    }
}


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Tipo Transacción</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_laboratorio">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_tipo_transaccion_vista"> Mantenimiento Tipo Transacción</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_tipotransaccion_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nuevo Tipo Transacción</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Ingrese el Tipo Transacción</label>
                                        <input class="form-control " class="tf w-input" type="text" id="txt_tipotransaccion1" name="txt_tipotransaccion1" onkeypress="return validacion_para_nombre(event)" required="" maxlength="50" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipotransaccion1');">

                                    </div>




                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_tipotransaccion" name="btn_guardar_tipotransaccion" <?php echo $_SESSION['btn_guardar_tipotransaccion']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                        <a href="../vistas/mantenimiento_tipo_transaccion_vista" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>


                                    </p>
                                </div>
                            </div>
                        </div>



                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>



                    <div class="RespuestaAjax"></div>
                </form>

            </div>
        </section>

    </div>





</body>

</html>
<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>