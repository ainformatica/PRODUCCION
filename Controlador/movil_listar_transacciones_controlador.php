<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');?>
<table id="tabla_transacciones" class="table table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>FECHA ENVIO</th>
            <th>REQUEST ENVIO</th>
            <th>RESPONSE</th>
            <th>ESTADO</th>

        </tr>
    </thead>
    <tbody>
        <?php
             $sql_tabla_transaccion_movil = "SELECT id,fecha_envio,request_envio,response,estado FROM tbl_movil_transacciones";
             if (isset($_POST)) {
                 if (!empty($_POST['final']) or !empty($_POST['buscar'])) {
                    $sql_tabla_transaccion_movil .= " WHERE ";
                 }
                 if (!empty($_POST['inicio']) and !empty($_POST['final'])) {
                     $inicio = $_POST['inicio'];
                     $final = $_POST['final'];
                     $sql_tabla_transaccion_movil .= " fecha_envio BETWEEN '$inicio' AND '$final'";
                 }
                 if (!empty($_POST['buscar'])) {
                     $dato = $_POST['buscar'];
                     $sql_tabla_transaccion_movil .= " request_envio like '%$dato%' or response like '%$dato%' or estado like '%$dato%'";
                 }
                }
                 $transacciones = array();
                 $resultadotabla_transacciones = $mysqli->query($sql_tabla_transaccion_movil);
                 while ($row = $resultadotabla_transacciones->fetch_array(MYSQLI_ASSOC)) {
                     $transacciones[] = $row;
                 ?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['fecha_envio']?></td>
            <td><?php echo $row['request_envio']?></td>
            <td><?php echo $row['response']?></td>
            <td><?php echo $row['estado']?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
$(function() {
        $('#tabla_transacciones').DataTable({
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

    var arrayJS = <?php echo json_encode($transacciones) ?>;
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
        pdf.text(110, 30, "DEPARTAMENTO DE INFORMÁTICA ");
        pdf.setFont('Arial', 'B');
        pdf.setFontSize(14);
        pdf.text(110, 38, "REPORTE DE TRANSACCIONES");
        pdf.setFontSize(11);
        pdf.text(250,43,'<?php echo $fecha?>');
        var columns = ["#", "Fecha de envío","Request de envío","Response","Estado"];
          var data = [];
          for (var i = 0; i < arrayJS.length; i++) {
            data.push([i + 1, arrayJS[i]['fecha_envio'],arrayJS[i]['request_envio'],arrayJS[i]['response'], arrayJS[i]['estado']]);
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