<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');




ob_end_flush();

$usuario=$_SESSION['id_usuario'];
        $id="SELECT id_persona AS supervisor from tbl_usuarios where id_usuario='$usuario'";
        $result= mysqli_fetch_assoc($mysqli->query($id));
        $id_supervisor=$result['supervisor'];

        $_SESSION['id_supervisor']= $id_supervisor;

?>


<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <script type="text/javascript" src="../js/supervisiones/segunda_visita.js"></script>

  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />


</head>

<body>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Vinculacion</li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla  -->

        <form action="../Controlador/guardar_segunda_visita_controlador.php" method="post" id="formulario" data-form="save" autocomplete="off" class="FormularioAjax">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">PRÁCTICA PROFESIONAL SUPERVISADA PPS-IA-02 </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12">
                  <label>DATOS GENERALES</label>
                  <hr>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <p><label>Seleccione un Alumno</label>
                      <select class="form-control" name="curso" id="curso" onclick='llenarCampos(this);'>
                        <option value="" selected hidden>Seleccione</option>
                      </select>
                  </div>
                </div>




                <input type="text" id="idInput" name="idInput" class="input" hidden />

                <div class="col-sm-12">
                  <label>INFORMACIÓN DEL ESTUDIANTE</label>
                  <hr>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre del estudiante</label>
                    <input class="form-control" type="text" id="estudiante_sv" name="estudiante_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Número de cuenta</label>
                    <input class="form-control" type="text" id="cuenta_sv" name="cuenta_sv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>DNI</label>
                    <input class="form-control" type="text" id="DNI_sv" name="DNI_sv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Celular</label>
                    <input class="form-control" type="text" id="celular_e_sv" name="celular_e_sv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input class="form-control" type="text" id="correo_e_sv" name="correo_e_sv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-12">
                  <label>INFORMACIÓN DE LA INSTITUCIÓN</label>
                  <hr>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre de la institución</label>
                    <input class="form-control" type="text" id="empresa_sv" name="empresa_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Dirección de la institución</label>
                    <input class="form-control" type="text" id="empresa_d_sv" name="empresa_d_sv" maxlength="60" readonly>
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <label>INFORMACIÓN DEL JEFE INMEDIATO</label>
                  <hr>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="jefe_sv" name="jefe_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nivel Académico</label>
                    <input class="form-control" type="text" id="titulo_sv" name="titulo_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Cargo</label>
                    <input class="form-control" type="text" id="cargo_sv" name="cargo_sv" maxlength="60" readonly>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Correo electrónico </label>
                    <input class="form-control" type="text" id="correo_sv" name="correo_sv" maxlength="60" readonly>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Teléfono</label>
                    <input class="form-control" type="text" id="telefono_sv" name="telefono_sv" data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Celular</label>
                    <input class="form-control" type="text" id="celular_sv" name="celular_sv" data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <label>INFORMACIÓN DE PRÁCTICA PROFESIONAL</label>
                  <hr>
                </div>
                 
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Modalidad</label>
                    <input class="form-control" type="text" id="modalidad_sv" name="modalidad_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Fecha de inicio</label>
                    <input class="form-control" type="text" id="inicio_sv" name="inicio_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Fecha de finalización</label>
                    <input class="form-control" type="text" id="finalizacion_sv" name="finalizacion_sv" maxlength="60" readonly>
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Jornada Laboral</label>
                    <input class="form-control" type="text" id="jornada_sv" name="jornada_sv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Horario Laboral</label>
                    <input class="form-control" type="text" id="horas_sv" name="horas_sv" maxlength="60" readonly>
                  </div>
                </div>




                <div class="col-sm-6">
                  <div class="form-group">

                  </div>
                </div>

                <!--<div class="col-sm-12">
                  <div class="form-group">
                  <label> </label>
                    <input class="form-control" type="text" id="otros_uv" name="otros_uv" maxlength="60" placeholder="Otros"  >
                </div>
                 </div>-->




                <div class="col-sm-12">
                  <label></label>
                  <hr>
                </div>

                <div class="col-sm-12">
                  <br>
                  <label>EVALUACIÓN DEL DESEMPEÑO</label>
                  <hr>
                </div>

                <p>INSTRUCCIONES: Lea detenidamente y seleccione el nivel que corresponda en cada uno de los aspectos objeto de evaluación, considerando la siguiente escala de valoración:
                <br>
                <br>
                1.	Deficiente: El aspecto evaluado no es aceptable.
                <br>
                2.	Regular: El aspecto evaluado satisface expectativas mínimas.
                <br>
                3.	Bueno: El aspecto evaluado es satisfactorio.
                <br>
                4.	Excelente: El aspecto evaluado es destacado.
                <br>
                N/A: No aplica 

                 </p>

                <div class="col-sm-12">
                  <label>A.	ACTITUD PROFESIONAL</label>
                </div>
                <br>
                <br>



                <table class="table">

                  <tr>

                    <th scope="row"></th>

                    <th>Deficiente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Regular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Bueno &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Excelente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>N/A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                  </tr>


                  <tr>

                    <th>Adaptación al ámbito profesional </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="adaptacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Lenguaje apropiado </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="lenguaje_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="lenguaje_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="lenguaje_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="lenguaje_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="lenguaje_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Capacidad de redacción </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidad_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidad_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidad_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidad_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidad_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Cumplimiento de horarios </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="cumplimiento_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Responsabilidad y cumplimiento de actividades </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Capacidad de investigación y análisis</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidadIA_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidadIA_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidadIA_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidadIA_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="capacidadIA_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Disposición para atender recomendaciones</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="disposicion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="disposicion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="disposicion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="disposicion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="disposicion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Liderazgo</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="liderazgo_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="liderazgo_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="liderazgo_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="liderazgo_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="liderazgo_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Resolución de problemas</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="resolucion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="resolucion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="resolucion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="resolucion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="resolucion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Toma de decisiones acertadas y oportunas</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tomadecisiones_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tomadecisiones_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tomadecisiones_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tomadecisiones_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tomadecisiones_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Nivel de proactividad demostrado</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactividad_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactividad_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactividad_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactividad_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactividad_sv" value="N/A" require></td>

                  </tr>

                </table>
              </div>

              <div class="col-sm-12">
                  <label></label>
                  <hr>
                </div>

              <div class="col-sm-12">
                  <label>B.	DESEMPEÑO PROFESIONAL</label>
                </div>
                <br>
                <br>



                <table class="table">

                  <tr>

                    <th scope="row"></th>

                    <th>Deficiente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Regular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Bueno &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>Excelente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    <th>N/A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                  </tr>


                  <tr>

                    <th>Planificación para el desarrollo de actividades </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="planificacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="planificacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="planificacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="planificacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="planificacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Calidad del trabajo realizado </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="calidad_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Presentación continua de avances y reportes de estado  </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Participación en proyectos y presentación de entregables </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="participacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="participacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="participacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="participacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="participacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Aplicación de estándares y buenas prácticas </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aplicacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aplicacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aplicacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aplicacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="aplicacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Creación de valor agregado </th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>

                    <th>Nivel de actualización en áreas de conocimiento</th>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="actualizacion_sv" value="Deficiente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="actualizacion_sv" value="Regular" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="actualizacion_sv" value="Bueno" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="actualizacion_sv" value="Excelente" require></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="actualizacion_sv" value="N/A" require></td>

                  </tr>

                  <tr>
                  </table>
              </div>





              <div class="col-sm-12">

                <label></label>
                <hr>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Especifique las áreas o aspectos que el estudiante debe fortalecer para desempeñarse eficientemente como futuro profesional. </label>
                  <textarea class="form-control" id="areas_refuerzo_sv" name="areas_refuerzo_sv" rows="3" style="text-transform:uppercase" require></textarea>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label>En una escala de 1 a 10 en función del desempeño observado, indique la calificación final del estudiante.</label>
                  <select class="form-control" name="calificacion_sv" id="calificacion_sv" require>
                    <option value="">Seleccione</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
              </div>
              
              <div class="col-sm-12">
                <div class="form-group">
                  <label>¿Solicitaría nuevamente a uno de nuestros estudiantes para realizar práctica profesional en su institución?</label>
                  <select class="form-control" name="solicitar_practicante_sv" id="solicitar_practicante_sv" onchange="Mostrar_motivo();" require>
                    <option value="0">Seleccione</option>
                    <option value="Si">SI</option>
                    <option value="No">NO</option>
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">En caso de que su respuesta anterior sea NO, especifique el porqué.</label>
                  <textarea class="form-control" id="casono_sv" name="casono_sv" rows="3" style="text-transform:uppercase" require></textarea>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Otras observaciones sobre el practicante.</label>
                  <textarea class="form-control" id="otrasobservaciones_sv" name="otrasobservaciones_sv" rows="3" style="text-transform:uppercase" require></textarea>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label>Representante de la institución</label>
                  <input class="form-control" type="text" id="representante_sv" name="representante_sv" style="text-transform:uppercase" maxlength="60" require>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label>Supervisor</label>
                  <input class="form-control" type="text" id="supervisor_sv" name="supervisor_sv" style="text-transform:uppercase" maxlength="60" require>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label>Lugar</label>
                  <input class="form-control" type="text" id="lugar_sv" name="lugar_sv" style="text-transform:uppercase" maxlength="60" require>
                </div>
              </div>





            </div>
            <p class="text-center" style="margin-top: 20px;">
              <button type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" onclick="guardar()"><i class="zmdi zmdi-floppy"></i>Guardar</button>
            </p>
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




  <script type="text/javascript">
    function llenar_select2() {

      var cadena = "&activar=activar"
      $.ajax({
        url: "../Controlador/guardar_segunda_visita_controlador.php?op=selectCurso",
        type: "POST",
        data: cadena,
        success: function(r) {


          $("#curso").html(r).fadeIn();
        }


      });

    }
    llenar_select2();



    function llenarCampos(inputSelect) {
      document.getElementById("idInput").value = inputSelect.options[inputSelect.selectedIndex].value;
      var id_persona1 = inputSelect.options[inputSelect.selectedIndex].value;
      console.log(id_persona1);
      console.log("hola");




      $.post("../Controlador/guardar_segunda_visita_controlador.php?op=rellenarDatos", {
        id_persona: id_persona1
      }, function(data, status) {

        data = JSON.parse(data);
        console.log(data);

        //TBL_PRACTICA_ESTUDIANTES
        $("#modalidad_sv").val(data.modalidad);
        $("#inicio_sv").val(data.fecha_inicio);
        $("#finalizacion_sv").val(data.fecha_finalizacion);
        $("#jornada_sv").val(data.horario);
        $("#horas_sv").val(data.horas);
        //TBL_PERSONAS_EXTENDIDAS
        $("#cuenta_sv").val(data.valor);
        //TBL_EMPRESAS_PRACTICA
        $("#empresa_sv").val(data.nombre_empresa);
        $("#empresa_d_sv").val(data.direccion_empresa);
        $("#jefe_sv").val(data.nombre);
        $("#cargo_sv").val(data.cargo);
        $("#titulo_sv").val(data.nivel_a);
        $("#celular_sv").val(data.celular);
        $("#correo_sv").val(data.correo);
        $("#telefono_sv").val(data.telefono);
        //TBL_PERSONAS
        $("#estudiante_sv").val(data.nombres);
        $("#DNI_sv").val(data.identidad);
        $("#celular_e_sv").val(data.Celular);
        $("#correo_e_sv").val(data.Correo);




      })

    }

    function Mostrar_motivo()
    {
      /* Para obtener el valor */
      var aprobar = document.getElementById("solicitar_practicante_sv").value;


    if(aprobar == "No") {
      
        $('#casono_sv').prop("readonly", false);
      document.getElementById("casono_sv").value = "";

    }
    else

      {
        $('#casono_sv').prop("readonly", true);
      }

    }
  </script>

</body>

</html>