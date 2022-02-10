<?php 
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion(); ?>


<table id="tablaSegmento" class="table table-bordered table-striped" style="width:100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>NOMBRE</th>
      <th>DESCRIPCIÓN</th>
      <th>CREADO POR</th>
      <th>FECHA DE CREACIÓN</th>
      <th>EDITAR</th>
      <th>ELIMINAR</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql_segmentos = "SELECT s.id, s.nombre, s.descripcion, s.fecha_creacion,
                                   u.Usuario
                                   FROM tbl_movil_segmentos s 
                                   INNER JOIN  tbl_usuarios u ON s.creado_por = u.Id_usuario";
    if (isset($_POST)) {
      if (!empty($_POST['buscar'])) {
        $dato = $_POST['buscar'];
        $sql_segmentos .= " WHERE s.nombre LIKE '%$dato%' or s.descripcion LIKE '%$dato%' or s.fecha_creacion LIKE '%$dato%' or Usuario LIKE '%$dato%'";
      }
    }
        $resultado_segmentos = $instancia_conexion->ejecutarConsulta($sql_segmentos);
    $segmentos = array();
    while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) {
      $segmentos[] = $segmento;
    ?>
      <tr>
        <td><?php echo $segmento['id']; ?></td>
        <td><?php echo $segmento['nombre']; ?></td>
        <td><?php echo $segmento['descripcion']; ?></td>
        <td><?php echo $segmento['Usuario']; ?></td>
        <td><?php echo $segmento['fecha_creacion']; ?></td>

        <td style="text-align: center;">

          <a href="../vistas/movil_gestion_segmentos_vista.php?&id=<?php echo $segmento['id']; ?>" class="btn btn-primary btn-raised btn-xs">
            <i class="far fa-edit"></i>
          </a>
        </td>

        <td style="text-align: center;">
          <button type="submit" class="btn btn-danger btn-raised btn-xs" onclick="eliminar(<?php echo $segmento['id']; ?>)">
            <i class="far fa-trash-alt"></i>
          </button>
          <div class="RespuestaAjax"></div>
        </td>

      </tr>

    <?php } ?>


  </tbody>
</table>
<script>
  $(function() {
    $('#tablaSegmento').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
      }
    });
  });

  var arrayJS = <?php echo json_encode($segmentos) ?>;
  <?php date_default_timezone_set("America/Tegucigalpa");
  $fecha = date('d-m-Y h:i:s'); ?>
  $("#GenerarReporte").click(function() {
    var pdf = new jsPDF('landscape');
    var logo = new Image();
    logo.src = '../dist/img/logo_ia.jpg';
    pdf.addImage(logo, 15, 10, 30, 30);
    pdf.setFont('Arial', );
    pdf.setFontSize(12);
    pdf.text(90, 15, "UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS");
    pdf.text(70, 23, "FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES");
    pdf.text(105, 30, "DEPARTAMENTO DE INFORMÁTICA ");
    pdf.setFont('Arial', 'B');
    pdf.setFontSize(14);
    pdf.text(110, 38, "REPORTE DE SEGMENTOS");
    pdf.setFontSize(11);
    pdf.text(250, 43, '<?php echo $fecha ?>');
    var columns = ["#", "Nombre", "Descripción", "Creado Por", "Fecha de Creación"];
    var data = [];
    for (var i = 0; i < arrayJS.length; i++) {
      data.push([i + 1, arrayJS[i]['nombre'], arrayJS[i]['descripcion'], arrayJS[i]['Usuario'], arrayJS[i]['fecha_creacion']]);
    }

    pdf.autoTable(columns, data, {
      margin: {
        top: 45
      }
    });

    const addFooters = pdf => {
      const pageCount = pdf.internal.getNumberOfPages()

      pdf.setFont('helvetica', 'italic')
      pdf.setFontSize(9)
      for (var i = 1; i <= pageCount; i++) {
        pdf.setPage(i)
        pdf.text('Pag. ' + String(i) + ' de ' + String(pageCount), pdf.internal.pageSize.width / 2, 200, {
          align: 'center'
        })
      }
    }
    addFooters(pdf);
    window.open(pdf.output('bloburl'),'REPORTE');
    //pdf.save('Reporte_Segmento_' + '<?php echo $fecha ?>' + '.pdf');
  });
</script>
<?php ob_end_flush(); ?>