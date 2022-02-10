<?php 
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();
?>

<table id="tabla-noticias" class="table table-bordered table-striped" style="width:100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>TÍTULO</th>
      <th>SUBTÍTULO</th>
      <th>CONTENIDO</th>
      <th>FECHA Y HORA DE PUBLICACIÓN</th>
      <th>FECHA Y HORA DE VENCIMIENTO</th>
      <th>SEGMENTO</th>
      <th>EDITAR</th>
      <th>BORRAR</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT n.id, n.titulo, n.subtitulo, n.descripcion, n.fecha, n.fecha_vencimiento, n.remitente,
                            s.nombre
                            FROM tbl_movil_noticias n
                            INNER JOIN tbl_movil_segmentos s ON n.segmento_id = s.id";
                             if (isset($_POST)) {
                              if (!empty($_POST['buscar'])) {
                                $dato = $_POST['buscar'];
                                $sql .= " WHERE n.titulo LIKE '%$dato%' or n.subtitulo LIKE '%$dato%' or n.descripcion LIKE '%$dato%' or n.fecha LIKE '%$dato%' or n.fecha_vencimiento LIKE '%$dato%' or n.remitente LIKE '%$dato%' or s.nombre LIKE '%$dato%'";
                              }
                            }
    $resultado_noticias = $instancia_conexion->ejecutarConsulta($sql);
    $noticias = array();
    while ($fila = $resultado_noticias->fetch_array(MYSQLI_ASSOC)) {
      $noticias[] = $fila;
    ?>
      <tr>
        <td><?php echo $fila['id']; ?></td>
        <td><?php echo $fila['titulo']; ?></td>
        <td><?php echo $fila['subtitulo']; ?></td>
        <td><?php echo $fila['descripcion']; ?></td>
        <td><?php echo $fila['fecha']; ?></td>
        <td><?php echo $fila['fecha_vencimiento']; ?></td>
        <td><?php echo $fila['nombre']; ?></td>

        <td style="text-align: center;">
          <a href="../vistas/movil_gestion_noticia_vista.php?&id=<?php echo $fila['id']; ?>" class="btn btn-primary btn-raised btn-xs">
            <i class="far fa-edit"></i>
          </a>
        </td>

        <td style="text-align: center;">
          <button type="submit" class="btn btn-danger btn-raised btn-xs" onclick="eliminar(<?php echo $fila['id']; ?>)">
            <i class="far fa-trash-alt"></i>
          </button>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<script>
  $(function() {
    $('#tabla-noticias').DataTable({
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

  var arrayJS = <?php echo json_encode($noticias) ?>;
  <?php date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s'); ?>
  function GenerarReporte() {
    var pdf = new jsPDF('landscape');
    var logo = new Image();
    logo.src = '../dist/img/logo_ia.jpg';
    pdf.addImage(logo, 'JPEG', 15, 10, 30, 30);
    pdf.setFont('Arial', 'I');
    pdf.setFontSize(12);
    pdf.text(90, 15, "UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS");
    pdf.text(70, 23, "FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES");
    pdf.text(105, 30, "DEPARTAMENTO DE INFORMÁTICA ");
    pdf.setFont('Arial', 'B');
    pdf.setFontSize(14);
    pdf.text(115, 38, "REPORTE DE NOTICIAS");
    pdf.setFontSize(11);
    pdf.text(250,43,'<?php echo $fecha?>');
    var columns = ["#", "Titulo", "Subtitulo", "Contenido", "Fecha de Publicación", "Fecha de Vencimiento", "Remitente", "Segmento"];
    var data = [];
    for (var i = 0; i < arrayJS.length; i++) {
      data.push([i + 1, arrayJS[i]['titulo'], arrayJS[i]['subtitulo'], arrayJS[i]['descripcion'], arrayJS[i]['fecha'], arrayJS[i]['fecha_vencimiento'], arrayJS[i]['remitente'], arrayJS[i]['nombre']]);
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
    //pdf.save('ReporteNoticia_'+ '<?php echo $fecha?>' +'.pdf');
  }
</script>
<?php ob_end_flush();?>