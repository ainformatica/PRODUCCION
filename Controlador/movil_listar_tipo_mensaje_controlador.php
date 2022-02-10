<?php 
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php'); ?>
<table id="tabla" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th>ID</th>
              <th>TIPO MENSAJE</th>
              <th>EDITAR</th>
              <th>BORRAR</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_tipomensaje = "select * from tbl_movil_tipo_mensajes";
             if (isset($_POST)) {
              if (!empty($_POST['buscar'])) {
                $dato = $_POST['buscar'];
                $sql_tipomensaje .= " WHERE tipo_mensaje LIKE '%$dato%'";
              }
            }
            $tipo_mensajes = array();
            $resultado_tipomensaje = $mysqli->query($sql_tipomensaje);
            while ($tipomensaje = $resultado_tipomensaje->fetch_array(MYSQLI_ASSOC)) { 
              $tipo_mensajes[]=$tipomensaje;
              ?>
              <tr>
                <td><?php echo $tipomensaje['id']; ?></td>
                <td><?php echo $tipomensaje['tipo_mensaje']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/movil_mantenimiento_tipo_mensaje_vista.php?&id=<?php echo $tipomensaje['id']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit"></i>
                  </a>
                </td>

                <td style="text-align: center;">
                <button type="submit" class="btn btn-danger btn-raised btn-xs" onclick="eliminar(<?php echo $tipomensaje['id']; ?>)">
                      <i class="far fa-trash-alt"></i>
                    </button>
                    <div class="RespuestaAjax"></div>
                  </form>
                </td>

              </tr>

            <?php } ?>

          </tbody>
        </table>
     
  <script>

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
    
    var arrayJS = <?php echo json_encode($tipo_mensajes) ?>;
    <?php date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s'); ?>
        $("#GenerarReporte").click(function() {
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
          pdf.text(110,38,"REPORTE TIPO MENSAJE");
          var columns = ["#", "Tipo Mensaje"];
          var data = [];
          for (var i = 0; i < arrayJS.length; i++) {
            data.push([i + 1, arrayJS[i]['tipo_mensaje']]);
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
        //pdf.save('Reporte_Tipo_Mensaje_'+'<?php echo $fecha?>' +'.pdf');

        });


</script>
<?php ob_end_flush(); ?>