<?php
ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');


$Id_objeto = 12209;


$visualizacion = permiso_ver($Id_objeto);

if ($visualizacion == 0) {
   

    echo '<script type="text/javascript">
                            swal({
                                 title:"",
                                 text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                 type: "error",
                                 showConfirmButton: false,
                                 timer: 3000
                              });
                         window.location = "../vistas/pagina_principal_vista";

                          </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Modificar Salida');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_actualizar_salida_producto'] = "";
    } else {
        $_SESSION['btn_actualizar_salida_producto'] = "disabled";
    }


    if (isset($_GET['inventario'])) {
        $numero_inventario = $_GET['inventario'];
    }


    $sql = "call select_mostrar_datos_salida('$numero_inventario')";
    $resultado = $mysqli->query($sql);

    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    $_SESSION['idmotivo'] = $row['motivo'];
    $_SESSION['fecha'] = $row['fecha'];
    $_SESSION['descripcion'] = $row['descripcion'];
    $_SESSION['producto'] = $row['producto'];
    $_SESSION['caracteristicas'] = $row['caracteristicas'];
    $_SESSION['num_inventario'] = $numero_inventario;
}
ob_end_flush();
?>



<!DOCTYPE html>
<html>

<head>


</head>

<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Actualización Salida del producto</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_salida_vista">Gestión salida</a></li>
                        </ol>
                    </div>
                    <!-- VERIFICAR -->
                    <div class="RespuestaAjax"></div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->



        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/actualizar_salida_controlador.php" method="post" data-form="update" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h2 class="card-title">Datos del Producto Saliente</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">

                                    <!--    ENTRADA DEL PRODUCTO QUE BUSCO  -->
                                    <input class="form-control" readonly="true" value="<?php echo 'Producto:' . $_SESSION['producto'] . '  Caracteristicas: ' . $_SESSION['caracteristicas']; ?>" type="text" id="txt_propiedades" name="txt_propiedades" required="" maxlength="30" readonly="true" disabled="true" style="text-transform: uppercase; height:38px; width:608px;" onkeyup="Espacio(this, event)" onkeypress="return Letras(event)">


                                    <!-- FECHA DE LA SALIDA  -->
                                    <div class="form-group">
                                        <label>Fecha Salida</label>
                                        <input class="form-control" readonly="true" type="text" id="fecha_editada" value="<?php echo $_SESSION['fecha']; ?>" name="fecha_editada" maxlength="30" required>
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label">Estado del producto</label>
                                        <select class="form-control select2" style="width: 100%;" id="cmb_estado_producto" name="cmb_estado_producto" required>   
                                        <!-- <option   >Seleccione un tipo de Producto:</option> -->
                                                <?php
                                                        $sql = "SELECT a.id_estado as id_estado_producto, a.estado as estado_producto FROM tbl_estado a inner join tbl_detalle_adquisiciones b WHERE a.id_estado = b.id_estado and b.numero_inventario = '$numero_inventario'";
                                                        $resultado = $connection->query($sql);
                                                        $row = $resultado->fetch_array(MYSQLI_ASSOC);
                                                        $id_estado_producto=$row['id_estado_producto'];
                                                        $estado_producto=$row['estado_producto'];

                                                            $query = $connection -> query ("select * FROM tbl_estado where id_estado <> 1 and id_estado <> 2 and id_estado <> 4 and id_estado <> $id_estado_producto");
                                                            while ($resultado = mysqli_fetch_array($query)) 
                                                            {
                                                            
                                                            echo '<option value="'.$resultado['id_estado'].'"  > '.$resultado['estado'].'</option>' ;
                                                            }
                                                            
                                                            echo '<option value="'. $id_estado_producto.'" selected="" >  '.$estado_producto.'</option>' ; 
                                                ?>
                                        </select>      
                                    </div>

                                    <!-- LA DESCRIPCION DE BAJA -->
                                    <div class="form-group ">
                                        <textarea class="form-control" style="text-transform: uppercase" class="tf w-input" required type="text" maxlength="100" name="descripcion" id="descripcion" rows="5" cols="40" onkeyup="DobleEspacio(this, event); MismaLetra('descripcion');" onkeypress="return validacion_para_producto(event)"><?php echo $_SESSION['descripcion']; ?></textarea>
                                    </div>

                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_salida" name="btn_guardar_salida" <?php echo $_SESSION['btn_actualizar_salida_producto']; ?>><i class="zmdi zmdi-floppy"></i>Actualizar</button>
                                        <a href="../vistas/gestion_salida_vista" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer"></div>

                    </div>

                    <div class="RespuestaAjax"></div>

                </form>
            </div>
        </section>
    </div>
</body>

</html>


<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<script src="{{asset('libs/SB-Admin/js/moment.js')}}"></script>