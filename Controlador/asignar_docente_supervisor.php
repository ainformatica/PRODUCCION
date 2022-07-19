<?php
ob_start();
session_start();
require_once('../clases/Conexion.php');


$obs_prac = strtoupper ($_POST['docente']);
$id = strtoupper( $_POST['id_estudiante']);

    $sql= ("UPDATE tbl_practica_estudiantes SET docente_supervisor='$obs_prac', primera_supervision=0, segunda_supervision=0 WHERE id_persona='$id'") or die(mysqli_error($connection));
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
             window.location.href = "../vistas/gestion_docente_supervisor_vista.php"
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