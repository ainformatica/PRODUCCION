<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
// require_once('../clases/Conexion.php');
require_once "../Modelos/detalle_existencias_modelo.php";
// require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 12206;
$visualizacion = permiso_ver($Id_objeto);
if (isset($_GET['id_producto'])) {
  $id_producto1 = $_GET['id_producto'];
} else {
  $id_producto = '';
}




if ($visualizacion == 0) {
  
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/pagina_inicio_vista";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Reportes de detalles existencias');



  //   if (permisos::permiso_modificar($Id_objeto) == '1') {
  //     $_SESSION['ver_detalle_existencias'] = "";
  //   } else {
  //     $_SESSION['ver_detalle_existencias'] = "disabled";
  //   }
  $id_producto = intval($id_producto1);

  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  // $sqltabla = "CALL sel_reportes_existencia_asignados('$id_producto')";
  $sqltabla = "SELECT inv.id_inventario,dc.numero_inventario, p.id_producto,p.nombre_producto,ub.ubicacion as ubicacion,GROUP_CONCAT(distinctrow tic.tipo_caracteristica,': ',deca.valor_caracteristica SEPARATOR ', ')
  as caracteristicas FROM tbl_detalle_adquisiciones dc inner join tbl_inventario inv inner join tbl_productos p
  INNER JOIN tbl_caracteristicas_producto cp INNER JOIN tbl_detalle_caracteristica deca INNER JOIN tbl_tipo_caracteristica tic INNER JOIN tbl_asignaciones TA
INNER JOIN tbl_ubicacion ub
  ON cp.id_producto = dc.id_producto and deca.id_caracteristica_producto= cp.id_caracteristica_producto
  and dc.id_detalle =deca.id_detalle and tic.id_tipo_caracteristica=cp.id_tipo_caracteristica and p.id_producto=cp.id_producto and TA.id_detalle=dc.id_detalle and TA.id_ubicacion=ub.id_ubicacion
  where cp.id_producto='$id_producto' and inv.id_producto='$id_producto' and dc.id_estado=4
  GROUP by id_inventario,numero_inventario,id_producto,nombre_producto,ubicacion";

// $sqltabla = "CALL sel_reportes_existencia_asignados3('$id_producto')";
 $sql="SELECT inv.id_inventario,dc.numero_inventario, p.id_producto,p.nombre_producto, GROUP_CONCAT(distinctrow tic.tipo_caracteristica,': ',deca.valor_caracteristica SEPARATOR ', ')
 as caracteristicas FROM tbl_detalle_adquisiciones dc inner join tbl_inventario inv inner join tbl_productos p
 INNER JOIN tbl_caracteristicas_producto cp INNER JOIN tbl_detalle_caracteristica deca INNER JOIN tbl_tipo_caracteristica tic 
 ON cp.id_producto = dc.id_producto and deca.id_caracteristica_producto= cp.id_caracteristica_producto
 and dc.id_detalle =deca.id_detalle and tic.id_tipo_caracteristica=cp.id_tipo_caracteristica and p.id_producto=cp.id_producto 
 where cp.id_producto='$id_producto' and inv.id_producto='$id_producto' and dc.asignado=0 and dc.id_estado=4
 GROUP by id_inventario,numero_inventario,id_producto,existencia";
  $resultadotabla = $mysqli->query($sqltabla);
  $resultado= $connection->query($sql);
}


ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
  <title></title>
</head>


<body>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>Detalle - Producto existencias
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/reportes_existencias_vista">Consulta Existencias</a></li>
              <!-- <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_tipoadquisicion_vista.php">Nuevo Tipo Adquisición</a></li> -->
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title"></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
          <!-- <a target="_blank" href="../pdf/reporte_detalle_existencias_lab.php?id_producto=<?php echo $id_producto; ?>" class="btn btn-warning" id="btnreporte"><i class="fa fa-file-pdf-o" ></i> Generar Reporte</a> -->

        </div>
      </div>

      <div class="card-body">
        <!-- <div style="padding: 2px;"><a href="mantenimiento_crear_tipoadquisicion_vista.php" class=" btn btn-success btn-inline float-right mt-0" ><i class="fas fa-plus pr-2"></i>Nuevo</a></div> -->
        <table id="tblReporte_detalle_existencias" class="table table-bordered table-striped">



          <thead>
            <tr>
              <!-- <th>NO.</th> -->
              <th>NO. INVENTARIO</th>
              <th>PRODUCTO</th>
              <th>UBICACIÓN</th>
              <th>CARACTERISTÍCAS</th>

            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>

                <!-- <td><?php echo $row['id_inventario'] ?></td> -->
                <td><?php echo $row['numero_inventario']; ?></td>
                <td><?php echo $row['nombre_producto']; ?></td>
                <td><?php echo $row['ubicacion']; ?></td>
                <td><?php echo $row['caracteristicas']; ?></td>


                <!-- <td style="text-align: center;">
                    <a href="../vistas/reportes_detalle_existencias_vista.php?id_producto=<?php echo $row['id_producto']; ?>" class="btn btn-primary btn-raised btn-xs px-3">
                   <i class="far fa-edit" style="display:<?php echo $_SESSION['ver_detalle_existencias'] ?> "></i> -->
                <!-- Ver mas -->
                <!-- </a> -->
                <!-- </td> -->

              </tr>

            <?php } ?>
            <!-- echo var_dump($resultadotabla1); -->
            <?php 
            // $modelo = new respuesta();
            // $respuesta = $modelo->producto($id_producto);

            while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>

                <!-- <td><?php echo $row['id_inventario'] ?></td> -->
                <td><?php echo $row['numero_inventario']; ?></td>
                <td><?php echo $row['nombre_producto']; ?></td>
                <td></td>
                <td><?php echo $row['caracteristicas']; ?></td>


                <!-- <td style="text-align: center;">
                    <a href="../vistas/reportes_detalle_existencias_vista.php?id_producto=<?php echo $row['id_producto']; ?>" class="btn btn-primary btn-raised btn-xs px-3">
                     <i class="far fa-edit" style="display:<?php echo $_SESSION['ver_detalle_existencias'] ?> "></i> -->
                <!-- Ver mas -->
                <!-- </a> -->
                <!-- </td> -->

              </tr>

            <?php } ?>




          </tbody>
        </table>

        <!-- <div class="modal-footer justify-content-between"> -->
        <!-- <button type="submit" class="btn btn-danger float-right mt-3" id="btn_cancelar_ubicacion" name="btn_cancelar_ubicacion" <?php echo $_SESSION['btn_cancelar_ubicacion']; ?>>Cancelar</button> -->
        <!-- </div> -->

      </div>
      <!-- /.card-body -->
    </div>


    <!-- /.card-body -->
    <div class="card-footer">

    </div>
  </div>



  <!-- <script type="text/javascript">
    $(function() {

      $('#tblReporte_detalle_existencias').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "language": {
            "url": "../plugins/lenguaje.json"
        },
      });
    });
  </script>  -->


</body>

</html>


<script type="text/javascript" src="../js/pdf_gestion_laboratorio.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>


<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>