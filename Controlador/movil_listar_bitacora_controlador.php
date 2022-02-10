<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');
?>


<table id="tabla_bitacora" class="table table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th>USUARIO</th>
            <th>OBJETO</th>
            <th>ACCIÓN</th>
            <th>DESCRIPCIÓN</th>
            <th>FECHA y HORA</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_tabla_bitacora_movil = "SELECT u.Usuario, o.objeto, b.accion, b.descripcion, b.fecha from tbl_usuarios u
        INNER JOIN tbl_movil_bitacora b
        INNER JOIN tbl_objetos o on u.Id_usuario=b.usuario_id and b.objeto_id=o.Id_objeto";
        if (isset($_POST)) {
             if (!empty($_POST['final']) or !empty($_POST['buscar'])) {
                $sql_tabla_bitacora_movil .= " WHERE ";
            }
            if (!empty($_POST['inicio']) and !empty($_POST['final'])) {
                $inicio = $_POST['inicio'];
                $final = $_POST['final'];
                $sql_tabla_bitacora_movil .= "fecha BETWEEN '$inicio' AND '$final'";
            }
            if (!empty($_POST['buscar'])) {
                $dato = $_POST['buscar'];
                $sql_tabla_bitacora_movil .= " u.Usuario LIKE '%$dato%' or o.objeto LIKE '%$dato%' or b.accion LIKE '%$dato%'";
              }
        }
        $sql_tabla_bitacora_movil .= " ORDER BY b.fecha DESC";
        $bitacoras = array();
        $resultadotabla_bitacora = $mysqli->query($sql_tabla_bitacora_movil);
        while ($row = $resultadotabla_bitacora->fetch_array(MYSQLI_ASSOC)) {
            $bitacoras[] = $row;
        ?>
            <tr>
                <td><?php echo $row['Usuario']; ?></td>
                <td><?php echo $row['objeto']; ?></td>
                <td><?php echo strtoupper($row['accion']); ?></td>
                <td><?php echo strtoupper($row['descripcion']); ?></td>
                <td><?php echo $row['fecha']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(function() {
        $('#tabla_bitacora').DataTable({
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

    var arrayJS = <?php echo json_encode($bitacoras) ?>;
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
        pdf.text(120, 38, "REPORTE DE BITÁCORA");
        pdf.setFontSize(11);
        pdf.text(250,43,'<?php echo $fecha?>');
        var columns = ["#", "Usuario", "Objeto", "Acción", "Descripción", "Fecha"];
        var data = [];
        for (var i = 0; i < arrayJS.length; i++) {
            data.push([i + 1, arrayJS[i]['Usuario'], arrayJS[i]['objeto'], arrayJS[i]['accion'], arrayJS[i]['descripcion'], arrayJS[i]['fecha']]);
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