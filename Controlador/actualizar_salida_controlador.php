<?php
ob_start();

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 12209;
$nueva_descripcion = mb_strtoupper($_POST['descripcion']);
$id_motivo =$_SESSION['idmotivo'];
$estado_producto=$_POST['cmb_estado_producto'];


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ012345689_\s]+$/";
if( preg_match($patron_texto, $_POST['descripcion']) )
{


                    



                        if (empty($nueva_descripcion)) {
                                echo '<script type="text/javascript">
                                swal({
                                title:"",
                                text:"no puede enviar vacia la descripcion",
                                type: "warning",
                                showConfirmButton: false,
                                timer: 3000
                                });
                        </script>';
                    } else {

                        $sql = "call proc_actualizar_dato_salida('$nueva_descripcion','$id_motivo','$estado_producto')";






                        $valor = "select a.descripcion, b.id_estado from tbl_motivo_salida a inner join tbl_detalle_adquisiciones b where a.id_detalle = b.id_detalle and a.id_motivo = '$id_motivo'";
                        $result_valor = $mysqli->query($valor);
                        $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                        if ($valor_viejo['descripcion'] <> $nueva_descripcion and $valor_viejo['id_estado'] <> $estado_producto) {
                            $Id_objeto = 209;
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA DESCRIPCION DE LA SALIDA: ' . $valor_viejo['descripcion'] . ' POR ' . $nueva_descripcion . ' Y EL ESTADO DEL PRODUCTO: ' . $valor_viejo['id_estado'] . ' POR ' . $estado_producto . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/gestion_salida_vista";
                              </script>';
                            } else {
                                echo '<script type="text/javascript">
                                        swal({
                                                title: "",
                                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                        });
                                        </script>';
                            }
                        }
                        else if ($valor_viejo['descripcion'] <> $nueva_descripcion) {
                            $Id_objeto = 209;
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA DESCRIPCION DE LA SALIDA: ' . $valor_viejo['descripcion'] . ' POR ' . $nueva_descripcion . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/gestion_salida_vista";
                              </script>';
                            } else {
                                echo '<script type="text/javascript">
                                        swal({
                                                title: "",
                                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                        });
                                        </script>';
                            }
                        }
                        else if ($valor_viejo['id_estado'] <> $estado_producto) {
                            $Id_objeto = 209;
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ESTADO DEL PRODUCTO EN SALIDA: ' . $valor_viejo['id_estado'] . ' POR ' . $estado_producto . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/gestion_salida_vista";
                              </script>';
                            } else {
                                echo '<script type="text/javascript">
                                        swal({
                                                title: "",
                                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                        });
                                        </script>';
                            }
                        } else {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "",
                                    text: "Error al actualizar lo sentimos,intente de nuevo.",
                                    type: "error",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            </script>';

                            } 

                             }                       
                            
}
else{   
    echo '<script type="text/javascript">
    swal({
        title:"",
        text:"El nombre solo puede contener espacios y letras",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
    </script>';
    }         

    
ob_end_flush();
?>  