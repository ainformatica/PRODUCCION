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
  <script type="text/javascript" src="../js/supervisiones/primera_visita.js"></script>

  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  </h> <body>


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

        <form action="../Controlador/guardar_primera_visita_controlador.php" id="formulario" method="post" data-form="save" autocomplete="off" class="FormularioAjax">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">PRÁCTICA PROFESIONAL SUPERVISADA PPS-IA-01 </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

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
                    <input class="form-control" type="text" id="estudiante_pv" name="estudiante_pv" maxlength="60" readonly>
                  </div>
                </div>

                  <div class="form-group">
                    <input class="form-control" type="hidden" id="supervisor_pv" name="supervisor_pv" value="<?php echo $id_supervisor ?>" maxlength="60" readonly>
                  </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Número de cuenta</label>
                    <input class="form-control" type="text" id="cuenta_pv" name="cuenta_pv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>DNI</label>
                    <input class="form-control" type="text" id="DNI_pv" name="DNI_pv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Celular</label>
                    <input class="form-control" type="text" id="celular_e_pv" name="celular_e_pv" readonly maxlength="60">
                  </div>
                </div>

                <div class="col-sm-5">
                  <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input class="form-control" type="text" id="correo_e_pv" name="correo_e_pv" readonly maxlength="60">
                  </div>
                </div>

                <input hidden="true" name="id_primera_visita" id="id_primera_visita">

                <div class="col-sm-12">
                  <label>INFORMACIÓN DE LA INSTITUCIÓN</label>
                  <hr>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre de la institución</label>
                    <input class="form-control" type="text" id="empresa_pv" name="empresa_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Dirección de la institución</label>
                    <input class="form-control" type="text" id="empresa_d_pv" name="empresa_d_pv" maxlength="60" readonly>
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <label>INFORMACIÓN DEL JEFE INMEDIATO</label>
                  <hr>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre del jefe inmediato</label>
                    <input class="form-control" type="text" id="jefe_pv" name="jefe_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nivel Académico</label>
                    <input class="form-control" type="text" id="titulo_pv" name="titulo_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Cargo</label>
                    <input class="form-control" type="text" id="cargo_pv" name="cargo_pv" maxlength="60" readonly>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Correo electrónico </label>
                    <input class="form-control" type="text" id="correo_pv" name="correo_pv" maxlength="60" readonly>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Teléfono</label>
                    <input class="form-control" type="text" id="telefono_pv" name="telefono_pv" data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Celular</label>
                    <input class="form-control" type="text" id="celular_pv" name="celular_pv" data-inputmask='"mask": " 9999-9999"' data-mask readonly>
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <label>INFORMACIÓN DE PRÁCTICA PROFESIONAL</label>
                  <hr>
                </div>
                 
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Modalidad</label>
                    <input class="form-control" type="text" id="modalidad_pv" name="modalidad_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Fecha de inicio</label>
                    <input class="form-control" type="text" id="inicio_pv" name="inicio_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Fecha de finalización</label>
                    <input class="form-control" type="text" id="finalizacion_pv" name="finalizacion_pv" maxlength="60" readonly>
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Jornada Laboral</label>
                    <input class="form-control" type="text" id="jornada_pv" name="jornada_pv" maxlength="60" readonly>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Horario Laboral</label>
                    <input class="form-control" type="text" id="horas_pv" name="horas_pv" maxlength="60" readonly>
                  </div>
                </div>




                <!-- <div class="col-sm-6">
                  <div class="form-group">
                  <label>Nombre del puesto que desempeña el estudiante</label>
                    <input class="form-control" type="text" id="sps_puesto_pv" name="puesto_pv" maxlength="60"  readonly>
                </div>
                 </div>-->

                <div class="col-sm-12">
                  <br>
                  <br>
                  <br>
                  <label>FUNCIONES QUE REALIZA</label>
                  <hr>
                </div>

                <div class="col-sm-6">
                  <input type="checkbox" value="Análisis y diseño de sistemas" name="funciones_analisis_pv" /> <label> 1. Análisis y diseño de sistemas</label><br />
                  <input type="checkbox" value="Desarrollo de aplicaciones" name="funciones_desarrollo_pv" /> <label> 2. Desarrollo de aplicaciones </label><br />
                  <input type="checkbox" value="Bases de datos" name="funciones_bases_pv" /> <label> 3. Bases de datos</label><br />
                </div>


                <div class="col-sm-6">
                  <input type="checkbox" value="Testing" name="funciones_testing_pv" /> <label> 7.Testing </label><br />
                  <input type="checkbox" value="Seguridad Informática" name="funciones_seguridad_pv" /> <label> 8. Seguridad Informática</label><br />
                  <input type="checkbox" value="Inteligencia de negocios" name="funciones_negocios_pv" /> <label> 9. Inteligencia de negocios</label><br />
                </div>

                <div class="col-sm-6">
                  <input type="checkbox" value="Redes y comunicación de datos" name="funciones_redes_pv" /> <label> 4. Redes y comunicación de datos </label><br />
                  <input type="checkbox" value="Soporte técnico y atención a usuarios" name="funciones_soporte_pv" /> <label> 5. Soporte técnico y atención a usuarios</label><br />
                  <input type="checkbox" value="Monitoreo de procedimientos y políticas tecnológicas" name="funciones_monitoreo_pv" /> <label> 6. Monitoreo de procedimientos y políticas tecnológicas</label><br />
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Otros (especifique)</label>
                    <input class="form-control" type="text" id="otras_funciones_pv" name="otras_funciones_pv" maxlength="60" require>
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
                  <br><br>
                  <br>
                  <label>EVALUACION PERSONAL</label>
                  <hr>
                </div>

                <div class="col-sm-12">
                  <label>A.	ACTITUDES PERSONALES</label>
                </div>
                <br>
                <br>
                <p> 1.	Deficiente: El aspecto evaluado no es aceptable.
                <br>
                    2.	Regular: El aspecto evaluado satisface expectativas mínimas.
                    <br>
                    3.	Bueno: El aspecto evaluado es satisfactorio.
                    <br>
                    4.	Excelente: El aspecto evaluado es destacado.
                 </p>


                <div class="col-sm-12">
                  <table class="table">

                    <tr>

                      <th scope="row"></th>

                      <th>Deficiente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Regular&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Bueno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Excelente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    </tr>


                    <tr>

                      <th>Disposición al trabajo asignado</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="comunicacion_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Capacidad de comunicación</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="puntualidad_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Trabajo en equipo</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="responsabilidad_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Orientación al cambio</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="creatividad_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Innovación y creatividad</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Deficiente" require> </td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Regular" require> </td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Bueno" require> </td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="presentacion_pv" value="Excelente" require> </td>

                    </tr>

                    <tr>

                      <th>Responsabilidad y compromiso</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="atencion_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Empatía, cortesía y buen trato hacia compañeros de trabajo</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="programador_pv" value="Excelente" require></td>

                    </tr>

                  </table>
                </div>




                <br>


                <div class="col-sm-12">
                  <br><br>
                  <br>
                  <label>B.	INTEGRACIÓN INSTITUCIONAL</label><br>
                  <br>
                </div>




                <div class="col-sm-12">
                  <table class="table">

                    <tr>

                      <th scope="row"></th>

                      <th>Deficiente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Regular&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Bueno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                      <th>Excelente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                    </tr>


                    <tr>

                      <th>Capacidad de identificación de objetivos institucionales</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="colaborativo_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Comprensión del sector o rubro de negocio</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trabajo_equipo_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Comprensión de normativas y políticas institucionales</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="proactivo_iniciativa_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Comprensión de asignaciones y requerimientos</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="relaciones_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Disciplina para realizar actividades</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="analisis_pv" value="Excelente" require></td>

                    </tr>

                    <tr>

                      <th>Interés para adquirir conocimientos</th>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Deficiente" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Regular" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Bueno" require></td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="diseno_pv" value="Excelente" require></td>

                    </tr>

                  </table>
                </div>
                <hr>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Representante de la institución</label>
                    <input class="form-control" type="text" id="representante_pv" name="representante_pv" maxlength="60" require>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Supervisor</label>
                    <input class="form-control" type="text" id="supervisor_pv" name="supervisor_pv" maxlength="60" require>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Lugar</label>
                    <input class="form-control" type="text" id="lugar_pv" name="lugar_pv" maxlength="60" require>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Fecha</label>
                    <input class="form-control" type="date" id="fecha_pv" name="fecha_pv" maxlength="60" require>
                  </div>
                </div>





              </div>
              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" onclick="guardar();"><i class="zmdi zmdi-floppy"></i>Guardar</button>
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
        url: "../Controlador/guardar_primera_visita_controlador.php?op=selectCurso",
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




      $.post("../Controlador/guardar_primera_visita_controlador.php?op=rellenarDatos", {
        id_persona: id_persona1
      }, function(data, status) {

        data = JSON.parse(data);
        console.log(data);
        //mostrarform(true);
        //TBL_PRACTICA_ESTUDIANTES
        $("#modalidad_pv").val(data.modalidad);
        $("#inicio_pv").val(data.fecha_inicio);
        $("#finalizacion_pv").val(data.fecha_finalizacion);
        $("#jornada_pv").val(data.horario);
        $("#horas_pv").val(data.horas);
        //TBL_PERSONAS_EXTENDIDAS
        $("#cuenta_pv").val(data.valor);
        //TBL_EMPRESAS_PRACTICA
        $("#empresa_pv").val(data.nombre_empresa);
        $("#empresa_d_pv").val(data.direccion_empresa);
        $("#jefe_pv").val(data.nombre);
        $("#cargo_pv").val(data.cargo);
        $("#titulo_pv").val(data.nivel_a);
        $("#celular_pv").val(data.celular);
        $("#correo_pv").val(data.correo);
        $("#telefono_pv").val(data.telefono);
        //TBL_PERSONAS
        $("#estudiante_pv").val(data.nombres);
        $("#DNI_pv").val(data.identidad);
        $("#celular_e_pv").val(data.Celular);
        $("#correo_e_pv").val(data.Correo);



      })

    }
  </script>




  </body>

</html>