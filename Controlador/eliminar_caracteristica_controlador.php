<?php 
ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');

$Id_objeto = 12195;



$id="";
if (isset($_GET['tipo_caracteristica'])) {
    $tipo_caracteristica = $_GET['tipo_caracteristica'];
}


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
                                               window.location = "../vistas/gestion_preguntas_vista";

                            </script>';
}
else
{
                //llamamos al procedmiento almacenado para eliminar registros de tipo adquisicion
          $sql = "CALL proc_eliminar_caracteristicas_producto('$tipo_caracteristica'); ";
          $resultado = $mysqli->query($sql);
          if($resultado === TRUE){
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'LA CARACTERISTICA '.($tipo_caracteristica).' ');
            // header("location:../vistas/crear_caracteristicas_producto_vista.php?msj=5");
            	echo '<script type="text/javascript">
              swal({
                title:"",
                text:"Los datos se eliminaron correctamente",
                type: "success",
                showConfirmButton: false,
                timer: 3000
             });
                              
                                   $(".FormularioAjax")[0].reset();
                                   window.location = "../vistas/crear_caracteristicas_producto_vista";

                            </script>';
                      // }
                    
          
                                                       
          
          }else{
            echo '<script type="text/javascript">
            swal({
              title: "",
              text: "No se puede eliminar",
              type: "error",
              showConfirmButton: false,
              timer: 3000
          });
            



                                 $(".FormularioAjax")[0].reset();
                                 window.location = "../vistas/crear_caracteristicas_producto_vista";

                          </script>';




          }


}


ob_end_flush();


