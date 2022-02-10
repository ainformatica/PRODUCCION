<?php 
if(!isset($_SESSION)){ 
   session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion(); ?>

<table id="tabla" class="table table-bordered table-striped" style="width: 100%;">
   <thead>
      <tr>
         <th>ID</th>
         <th>PARÁMETRO</th>
         <th>DESCRIPCIÓN</th>
         <th>VALOR</th>
         <th>FECHA_MOD</th>
         <th>CREADO_POR</th>
         <th>MOD_POR</th>
         <th>EDITAR</th>
      </tr>
   </thead>
   <tbody>
      <?php
      $sql_parametros = "SELECT p.id,p.parametro,p.descripcion,p.valor,p.fecha_modificacion,p.creado_por,u.Usuario from tbl_movil_parametros p INNER JOIN tbl_usuarios u on u.Id_usuario = p.modificado_por";
      if (isset($_POST)) {
         if (!empty($_POST['buscar'])) {
             $dato = $_POST['buscar'];
             $sql_parametros .= " WHERE parametro LIKE '%$dato%' or descripcion LIKE '%$dato%' or fecha_modificacion LIKE '%$dato%' or creado_por LIKE '%$dato%' or modificado_por LIKE '%$dato%'";
         }
     }
     $parametros = array();
      $resultado_parametros = $mysqli->query($sql_parametros);
      while ($parametro = $resultado_parametros->fetch_array(MYSQLI_ASSOC)) { 
         $parametros[] = $parametro;
         ?>
         <tr>
            <td><?php echo $parametro['id']; ?></td>
            <td><?php echo $parametro['parametro']; ?></td>
            <td><?php echo $parametro['descripcion']; ?></td>
            <td><?php echo $parametro['valor']; ?></td>
            <td><?php echo $parametro['fecha_modificacion']; ?></td>
            <td><?php echo $parametro['creado_por']; ?></td>
            <td><?php echo $parametro['Usuario']; ?></td>

            <td style="text-align: center;">
               <a href="../vistas/movil_gestion_parametros_vista.php?&id=<?php echo $parametro['id']; ?>" class="btn btn-primary btn-raised btn-xs">
                  <i class="far fa-edit"></i>
               </a>
            </td>

         </tr>
      <?php } ?>
   </tbody>
</table>

<script type="text/javascript">
   $(function() {
      $('#tabla').DataTable({
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

   var arrayJS = <?php echo json_encode($parametros) ?>;
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
      pdf.text(110, 38, "REPORTE DE PARÁMETROS");
      var columns = ["#", "Parámetros", "Descripción", "Valor", "Fecha de Modificación", "Modificado Por", "Creado Por"];
      var data = [];
      for (var i = 0; i < arrayJS.length; i++) {
         data.push([i + 1, arrayJS[i]['parametro'], arrayJS[i]['descripcion'], arrayJS[i]['valor'], arrayJS[i]['fecha_modificacion'], arrayJS[i]['creado_por'], arrayJS[i]['Usuario']]);
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
      //pdf.save('Reporte_Parametro_' + '<?php echo $fecha ?>' + '.pdf');
   });
</script>
<?php ob_end_flush(); ?>