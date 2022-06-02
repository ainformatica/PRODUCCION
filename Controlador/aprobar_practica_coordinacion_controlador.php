<?php
ob_start();
session_start();
require_once('../clases/Conexion.php');


$obs_prac = strtoupper ($_POST['txt_motivo_rechazo']);
$id = strtoupper( $_SESSION['id']);
$tipo = strtoupper ($_POST['cb_practica']);
$hrs_pps = strtoupper ($_POST['cb_horas_practica']);
$fecha_inicio_prac = strtoupper ($_POST['fecha_inicio']);
$fecha_final_prac = strtoupper ($_POST['fecha_finalizacion']);
$horario_incio_prac = strtoupper ($_POST['horario_incio']);
$horario_fin_prac = strtoupper ($_POST['horario_fin']);
$dias_prac = strtoupper ($_POST['dias']);


    $sql= "INSERT INTO tbl_vinculacion_aprobacion_practica (id_persona, id_horas, fecha_inicio, id_dias, horario_entrada, horario_salida, fecha_finalizacion, id_estado_vinculacion, motivo) 
    VALUES ('$id', '$hrs_pps', '$fecha_inicio_prac', '$dias_prac', '$horario_incio_prac', '$horario_fin_prac', '$fecha_final_prac', '$tipo', '$obs_prac')";
        $resultadop = $mysqli->query($sql);
    
        if ($resultadop === TRUE ) {

            echo '<script type="text/javascript">
            swal({
             title:"",
             text:"Los datos  se almacenaron correctamente",
             type: "success",
             showConfirmButton: false,
             timer: 3000
             });
             $(".FormularioAjax")[0].reset();
             </script>'; 
           } 
           else 
           {
            echo '<script type="text/javascript">
            swal({
             title:"",
             text:"Lo sentimos los datos no fueron guardados correctamente",
             type: "error",
             showConfirmButton: false,
             timer: 3000
             });
             $(".FormularioAjax")[0].reset();
             </script>'; 
           }

ob_end_flush();
?>