<?php 


ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');




$id="";
if (isset($_GET['tipo_caracteristica'])) {
    $tipo_caracteristica = $_GET['tipo_caracteristica'];
}

$Id_objeto=12200;

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
                                               window.location = "../vistas/mantenimiento_tipo_caracteristica_vista";

                            </script>';
}
else
{



//llamamos al procedmiento almacenado para eliminar registros de tipo caracteristica
  $sql = "call proc_eliminar_tipo_caracteristica('$tipo_caracteristica'); ";
  $resultado = $mysqli->query($sql);
	if($resultado === TRUE){
       bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'EL TIPO CARACTERISTICA '. $tipo_caracteristica.' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/mantenimiento_tipo_caracteristica_vista";

                            </script>'
                            ;                      

                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"El registro no puede ser eliminado",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 1500
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }
}


ob_end_flush();


?>