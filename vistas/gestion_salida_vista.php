<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el ya existe",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }

  if ($msj == 2) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Los datos se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';


    $sqltabla = "select TP.nombre_producto as producto,TMS.id_motivo as motivo, TDA.numero_inventario as inventario, TMS.descripcion as descripcion, TMS.fecha_salida as fecha, TE.estado as estado FROM tbl_productos TP INNER JOIN tbl_detalle_adquisiciones TDA INNER JOIN tbl_motivo_salida TMS INNER JOIN tbl_estado TE ON TP.id_producto=TDA.id_producto AND TMS.id_detalle=TDA.id_detalle AND TMS.id_estado=TE.id_estado;
";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }
}


$Id_objeto = 12208;
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
                           window.location = "../vistas/pagina_principal_vista";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A gestion Salida');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_salida'] = "";
  } else {
    $_SESSION['btn_modificar_salida'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "select TE.estado as estado_producto, TDA.numero_inventario as inventario, TP.nombre_producto as producto, TMS.descripcion as descripcion, TMS.fecha_salida as fecha, TMS.id_estado as estado,TMS.id_motivo as motivo FROM tbl_productos TP INNER JOIN tbl_detalle_adquisiciones TDA INNER JOIN tbl_motivo_salida TMS INNER JOIN tbl_estado TE ON TP.id_producto=TDA.id_producto AND TMS.id_detalle=TDA.id_detalle AND TDA.id_estado=TE.id_estado  
  ORDER BY `TE`.`estado` DESC";
  $resultadotabla = $mysqli->query($sqltabla);
}

ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
  <title></title>
</head>


<body>
  <!-- 1 FORMULARIO PRINCIPAL -->
  <div class="content-wrapper" id="tblListar">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-sm-6">
            <h1>Gestion Salidas
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="crear_salida_vista">Nueva Salida</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- i/.container-flud -->
    </section>


    <!--Parte central del formulario-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Salidas</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>

        <div class=" px-12">
        </div>
      </div>

      <div class="card-body">
        <div class="mb-3">
          <div  class="text-right" >
            <div class="btn-group">
              <div style="padding: 2px;"><a href="../pdf_laboratorio/reporte_salida_degt.php" target="_blank" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-file-pdf"></i> Reporte DEGT</a></div>
              <div style="padding: 2px;"><a href="crear_salida_vista" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>
            </div>
          </div>


          <!-- NOMBRE DE LA TABLA QUE ALOJA LOS PRODUCTOS -->
          <table id="tblsalidaproducto" class="table table-bordered table-striped">



            <thead>
              <tr>
                <th>NO. INVENTARIO</th>
                <th>PRODUCTO</th>
                <th>ESTADO PRODUCTO</th>
                <th>MOTIVO</th>
                <th>FECHA</th>
                <th>ESTADO SALIDA</th>
                <th>MODIFICAR</th>
                <th>ANULAR/RESTAURAR</th>
                <th>REPORTE</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
                      <?php  
                            if ($row['estado'] == '1') {
                              $_SESSION['estado_salida']= "PROCESADO";
                              $_SESSION['icono_estado_salida']= "fas fa-times-circle";
                              $_SESSION['color_icono_estado_salida']= "danger";
                            } else {
                              $_SESSION['estado_salida'] = "ANULADO";
                              $_SESSION['icono_estado_salida']= "fas fa-undo";
                              $_SESSION['color_icono_estado_salida']= "success";
                            }
                      ?>

                  <td><?php echo $row['inventario']; ?></td>
                  <td><?php echo $row['producto']; ?></td>
                  <td><?php echo $row['estado_producto']; ?></td>
                  <td><?php echo $row['descripcion']; ?></td>
                  <td><?php echo $row['fecha']; ?></td>
                  <td><?php echo $_SESSION['estado_salida']; ?></td>
                  <!-- editar -->
                  <td style="text-align: center;">
                    <a href="../vistas/editar_salida_vista?inventario=<?php echo $row['inventario'];?>" class="btn btn-primary btn-raised btn-xs">
                      <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_salida']?>"></i>
                    </a>
                  </td>

                  <!-- anular -->
                  <td style="text-align: center;">
                    <form action="../Controlador/anular_salida_controlador.php?motivo=<?php echo $row['motivo']; ?>&estado=<?php echo $row['estado']; ?>&inventario=<?php echo $row['inventario']; ?>" method="POST" class="FormularioAjax" autocomplete="off">
                      <button type="submit" class="btn btn-<?php echo $_SESSION['color_icono_estado_salida'] ?> btn-raised btn-xs">

                        <i class="<?php echo $_SESSION['icono_estado_salida'] ?>" style="display:<?php echo $_SESSION['eliminar_producto'] ?> "></i>
                      </button>
                      <div class="RespuestaAjax"></div>
                    </form>
                  </td>

                  <!-- reporte -->
                  <td style="text-align: center;">
                    <a href="../pdf_laboratorio/reporte_salida_lab.php?inventario=<?php echo $row['inventario']; ?>" target="_blank" class="btn btn-primary btn-raised btn-xs">
                      <i class="fas fa-clipboard-list"></i>
                    </a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>

      </div><!-- /.card-body -->


      <div class="card-footer">

      </div>

    </div><!-- /.card-default -->


  </div><!-- /.CIERRE CAJA GRANDE -->


  <!-- <script type="text/javascript" language="javascript">
    function ventana() {
      window.open("../Controlador/reporte__controlador.php", "REPORTE");
    }
  </script> -->





  <!-- <script type="text/javascript">
    $(function() {

      $('#tblsalidaproducto').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script> -->






</body>

</html>










<script type="text/javascript" src="../js/pdf_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>