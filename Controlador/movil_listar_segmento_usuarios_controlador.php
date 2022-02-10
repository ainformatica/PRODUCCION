<?php 
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php'); 
    if (isset($_POST)) {
        $segmento = $_POST['segmento'];
        $sql_nombre_segmento = "SELECT nombre FROM tbl_movil_segmentos WHERE id=$segmento";
        $rspta_nombre=$mysqli->query($sql_nombre_segmento)->fetch_assoc();
        $nombre_segmento = $rspta_nombre['nombre'];
    }

?>
<table id="tabla_segmento_usuario" class="table table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th hidden>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>BORRAR </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT u.Id_usuario,p.nombres,p.apellidos FROM tbl_personas p 
        INNER join tbl_usuarios u on p.id_persona=u.id_persona 
        INNER join tbl_movil_segmento_usuario su on su.usuario_id = u.Id_usuario and su.segmento_id = $segmento";
        $resultado = $mysqli->query($sql);
        $segmento_usuario = array();
        while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) { 
            $segmento_usuario[] = $fila;
            ?>
            <tr>
                <td hidden><?php echo $fila['Id_usuario']; ?></td>
                <td><?php echo $fila['nombres']; ?></td>
                <td><?php echo $fila['apellidos']; ?></td>
                <td style="text-align: center;">
                       <button type="submit" class="btn btn-danger btn-raised btn-xs" onclick="eliminar(<?php echo $fila['Id_usuario']; ?>,document.getElementById('Segmento').value)">
                            <i class="far fa-trash-alt"></i>
                        </button>
                </td>
           </tr>
        <?php } ?>
    </tbody>
</table>

<script>
   $(document).ready(function () {
      $('#tabla_segmento_usuario').DataTable({
        dom: 'Bfrtip',
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
      });
        });
    var arrayJS = <?php echo json_encode($segmento_usuario) ?>;
    <?php date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s'); ?>
        $("#GenerarReporte_segmento_usuario").click(function() {
          var pdf = new jsPDF('landscape');
          var logo = new Image();
          logo.src = '../dist/img/logo_ia.jpg';
          pdf.addImage(logo, 15, 10, 30, 30);
          pdf.setFont('Arial',);
          pdf.setFontSize(12);
          pdf.text(90, 15, "UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS");
          pdf.text(70, 23, "FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES");
          pdf.text(105, 30, "DEPARTAMENTO DE INFORMÁTICA ");
          pdf.setFont('Arial','B');
          pdf.setFontSize(14);
          pdf.text(105,38,"REPORTE SEGMENTO "+"<?php echo $nombre_segmento?>");
          pdf.setFontSize(11);
          pdf.text(250,43,'<?php echo $fecha?>');
          var columns = ["#", "Nombre","Apellido"];
          var data = [];
          for (var i = 0; i < arrayJS.length; i++) {
            data.push([i + 1,arrayJS[i]['nombres'], arrayJS[i]['apellidos']]);
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
        });
</script>

<?php ob_end_flush(); ?>