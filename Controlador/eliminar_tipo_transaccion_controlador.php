<?php 

ob_start();

session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');




$id="";
if (isset($_GET['tipo_transaccion'])) {
    $tipo_transaccion = $_GET['tipo_transaccion'];
}

$Id_objeto=12198;

if (permisos::permiso_eliminar($Id_objeto)=='0') {

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso para eliminar",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/mantenimiento_tipo_transaccion_vista";

                            </script>';
}
else
{



//llamamos al procedmiento almacenado para eliminar registros de tipo transaccion
  $sql = "call proc_eliminar_tipo_transaccion('$tipo_transaccion'); ";
  $resultado = $mysqli->query($sql);
	if($resultado === TRUE){
       bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'EL TIPO TRANSACCION '. $tipo_transaccion.' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/mantenimiento_tipo_transaccion_vista";

                            </script>'
                            ;                      

                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"El registro no puede ser eliminado",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3500
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }
}


ob_end_flush();

?>
