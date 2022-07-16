<?php

ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/conexion_mantenimientos.php');
$id_persona = "";
$id_persona = $_GET["id_persona"];
print_r($_GET);

ob_end_flush();
?>


<!DOCTYPE html>
<html>

  <head>

  </head>

  <body>


    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Asignar Docente Supervisor</h1>


            </div>



            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                <li class="breadcrumb-item "><a href="../vistas/menu_supervision_vista.php">Supervisión</a></li>
                </li>
              </ol>
            </div>

            <div class="RespuestaAjax"></div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- pantalla 1 -->

          <form action="../Controlador/asignar_docente_supervisor.php" method="post" name="formulario" id="formulario" data-form="save" autocomplete="off" class="FormularioAjax">

            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>

              <?php
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                <input type="text" class="d-none" name="id_estudiante" id="id_estudiante" value="<?php echo $id_persona; ?>">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input Type="hidden" name="id_supervisor" id="id_supervisor" value="<?php echo $id_persona ?>">
                      <label>Docente supervisor</label>
                      <select class="form-control" name="docente" id="docente" onchange="myFunction();">
                        <option value="" selected hidden>Seleccione</option>
                        <?php
                        $query = $mysqli->query("SELECT id_persona as docente, CONCAT(nombres,' ', apellidos) nombres FROM tbl_personas WHERE id_tipo_persona = 1 AND Estado = 'ACTIVO'");
                        while ($valores = mysqli_fetch_array($query)) {
                          echo '<option value="' . $valores['docente'] . '">' . $valores['nombres'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Estudiantes asignados al docente:</label>
                      <input class="form-control" readonly type="text" id="txt_asignados" name="txt_asignados">

                    </div>
                  </div>


                  <div class="col-md-2">
                    <div class="form-group" hidden>
                      <label>nombre docente:</label>
                      <input class="form-control" readonly type="text" id="txt_nombre_docente" name="txt_nombre_docente">

                    </div>
                  </div>



                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar" > Guardar</button>

                    <a href="../vistas/gestion_docente_supervisor_vista.php" class="btn btn-danger float-right ">Cancelar</a>
                  </div>

                </div>
              </div>
             </div>
              <div class="RespuestaAjax"></div>
          </form>

        </div>
      </section>


    </div>

  </body>
  <script>
    function myFunction() {
      var x = document.getElementById("id_supervisor").value;
        <?php
          $existe_docente="SELECT count(docente_supervisor) AS docente from tbl_practica_estudiantes where docente_supervisor=x";
          $data = mysqli_fetch_assoc($existe_docente);
        ?>
      document.getElementById("txt_asignados").innerHTML = $data;
    }
  </script>
</html>


