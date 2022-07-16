<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

if (isset($_REQUEST['msj']))
{
  $msj=$_REQUEST['msj'];

  if ($msj==1)
  {


    echo '<script type="text/javascript">
    swal({
     title:"",
     text:"Lo sentimos tiene campos por rellenar",
     type: "info",
     showConfirmButton: false,
     timer: 4000
     });
     $(".FormularioAjax")[0].reset();
     </script>';
   }
if ($msj==2)
   {
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
   if ($msj==3)
   {
            echo '<script type="text/javascript">
       swal({
         title:"",
         text:"Lo sentimos no se pudieron guardar los datos",
         type: "error",
         showConfirmButton: false,
         timer: 3000
         });
         $(".FormularioAjax")[0].reset();
         </script>';


     } 
 }



     $Id_objeto= 2009 ; 




     $visualizacion= permiso_ver($Id_objeto);



     if ($visualizacion==0)
     {
 // header('location:  ../vistas/menu_permisos_usuario_vista.php');
       echo '<script type="text/javascript">
       swal({
         title:"",
         text:"Lo sentimos no tiene permiso de visualizar la pantalla",
         type: "error",
         showConfirmButton: false,
         timer: 3000
         });
         window.location = "../vistas/menu_practica_vista.php";

         </script>';
       }

       else

       {
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A  APROBACION/RECHAZO DE PRACTICA ');


        if (permisos::permiso_insertar($Id_objeto)=='1')
        {
          $_SESSION['btn_aprobacion_rechazo_practica']="";
        }
        else
        {
          $_SESSION['btn_aprobacion_rechazo_practica']="disabled";
        }


        $sql_tabla_estudiantes_practica="SELECT DISTINCT p.id_persona as id, px.valor as valor, concat(p.nombres,' ',p.apellidos) as nombre, m.modalidad, ep.nombre_empresa,
        CASE 
        WHEN (sd.estado_coordinacion IS NULL and sd.estado_vinculacion='1') then
        'PENDIENTE' 
        END AS proceso,
        case
        when sd.estado_vinculacion IS NULL then 'PROCESO'
        else
        sd.estado_vinculacion end as estado_vinculacion, 
        case 
        when sd.estado_coordinacion IS NULL then 'PROCESO'
        else
        sd.estado_coordinacion end as estado_coordinacion
        from tbl_personas p, tbl_subida_documentacion sd, tbl_personas_extendidas px, tbl_modalidad m, tbl_empresas_practica ep, tbl_practica_estudiantes pe where sd.id_persona=p.id_persona AND m.id_modalidad=pe.id_modalidad AND px.id_atributo=12 and px.id_persona=p.id_persona and estado_coordinacion IS NULL and ep.id_persona=p.id_persona and pe.id_persona=p.id_persona";

  $resultadotabla_estudiantes_practica = mysqli_fetch_assoc($mysqli->query($sql_tabla_estudiantes_practica));
        $id_estudent=$resultadotabla_estudiantes_practica['id'];

        $_SESSION['txt_estudiante']=$resultadotabla_estudiantes_practica['nombre'];
        $_SESSION['cuenta']=$resultadotabla_estudiantes_practica['valor'];
        $_SESSION['Estado_proceso']=$resultadotabla_estudiantes_practica['proceso'];
        $_SESSION['estado_vin']=$resultadotabla_estudiantes_practica['estado_vinculacion'];
        $_SESSION['estado_coor']=$resultadotabla_estudiantes_practica['estado_coordinacion'];
        $_SESSION['id']=$resultadotabla_estudiantes_practica['id'];
        $_SESSION['modalidad']=$resultadotabla_estudiantes_practica['modalidad'];
        $resultadotabla_estudiantes_practica = $mysqli->query($sql_tabla_estudiantes_practica);

        $validar_aprobacion="SELECT count(tbl2.id_persona) AS persona FROM tbl_vinculacion_aprobacion_practica tbl2
          WHERE tbl2.id_persona = $id_estudent AND tbl2.id_estado_vinculacion=1 OR tbl2.id_estado_vinculacion=2";
          $aprobacion = mysqli_fetch_assoc($mysqli->query($validar_aprobacion));

          if ($aprobacion['persona']==1) {
            $btn_aprobacion="<button type='submit'  class='btn btn-secondary btn-raised btn-sm' name= 'btn_imprimir'>Imprimir";
          }else{
            $btn_aprobacion="<button type='button'  class='btn btn-warning btn-raised btn-sm' name= 'btn_imprimir'>Imprimir";
        }

 if (isset($_REQUEST['cuenta']))
        {
  
$sql_datos_modal="SELECT p.id_persona, px.valor as valor, concat(p.nombres,' ',p.apellidos) as nombre from  tbl_personas p, tbl_subida_documentacion sd , tbl_personas_extendidas px where sd.id_persona=p.id_persona AND px.id_atributo=12 and px.id_persona=p.id_persona and px.valor=$_REQUEST[cuenta]";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['id_es']=$resultado_datos['id_persona'];
          $_SESSION['cuenta']=$resultado_datos['valor'];

        ?>
        <script>
          $(function(){
            $('#modal_documentacion_estudiante').modal('toggle')

          })



        </script>;
        <?php 
 //Documentos enlistado.
          $listar=null;
          $directorio=opendir("../Documentacion_practica/$_SESSION[cuenta]/");
          while ($elemento =readdir($directorio)) 
          {
            if ($elemento !='.' and $elemento !='..') {


              if (is_dir("Documentacion_practica/$_SESSION[cuenta]/".$elemento)) 
              {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento/</a></li>";

              }

              else {
                $listar .="<li> <a href='../Documentacion_practica/$_SESSION[cuenta]/$elemento' target='_blank'>$elemento</a></li>";

              } 
            }
          }
        }

     if (isset($_REQUEST['cuenta_coordinacion']))
        {

          $sql_datos_modal="SELECT px.valor as valor, p.id_persona as id, concat(p.nombres,' ',p.apellidos) as nombre , sd.estado_vinculacion,ep.nombre_empresa,m.modalidad from  tbl_personas p, tbl_subida_documentacion sd,tbl_empresas_practica ep ,tbl_personas_extendidas px, tbl_practica_estudiantes pe, tbl_modalidad m where p.id_persona=sd.id_persona AND m.id_modalidad=pe.id_modalidad AND px.id_atributo=12 and px.id_persona=p.id_persona and px.valor=$_REQUEST[cuenta_coordinacion] and ep.id_persona=p.id_persona and pe.id_persona=p.id_persona";
          $resultado_datos = mysqli_fetch_assoc($mysqli->query($sql_datos_modal));
          $_SESSION['txt_estudiante']=$resultado_datos['nombre'];
          $_SESSION['cuenta']=$resultado_datos['valor'];
          $_SESSION['id_e']=$resultado_datos['id'];
          $_SESSION['empresa']=$resultado_datos['nombre_empresa'];
          $_SESSION['mod']=$resultado_datos['modalidad'];

       
     
          ?>
          <script>
            $(function(){
              $('#modal_aprobacion_practica').modal('toggle')

            })



          </script>;

          <?php 
        

        }



      }

      ob_end_flush();

      ?>


      <!DOCTYPE html>
      <html>
      <head>
        <title></title>
       
      </head>
      <body >



        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Estudiantes a Realizar Práctica  Profesional Supervisada  </h1>
                </div>
                <div class="RespuestaAjax"></div>



                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Vinculación </li>

                  </ol>
                </div>

                <div class="RespuestaAjax"></div>

              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <!-- pantalla 1 -->

              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Expedientes</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                     <div class="col-sm-4">
                  <!-- <div class="form-group">
                    <label>Tipo de institución</label>
                    <select class="form-control" name="cb_empresa" id="empresa">
                      <option selected disabled value="0">Seleccione una opción:</option>
                      
                    </select>
                  </div> -->
              </div>
                    <table id="tabla" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                       <th>NOMBRE COMPLETO</th>
                       <th>CUENTA</th>   
                       <th>EMPRESA</th>
                       <th>MODALIDAD</th>
                       <th>PROCESO</th>
                       <th>EXPEDIENTE</th>                
                       <th>APROBAR PRACTICA</th>  
                       <th>CONSTANCIA</th>                

                     </tr>
                   </thead>
                   <tbody>
                    <?php if ($_SESSION['Estado_proceso']=='PENDIENTE' and $_SESSION['estado_vin']==1) 
                    {
                     while($row = $resultadotabla_estudiantes_practica->fetch_array(MYSQLI_ASSOC)) { ?>
                      <tr>
                        <td><?php echo strtoupper($row['nombre']); ?></td>
                        <td><?php echo $row['valor']; ?></td>
                        <td><?php echo $row['nombre_empresa']; ?></td>
                        <td><?php echo $row['modalidad']; ?></td>
                        <td><?php echo $row['proceso']; ?></td>


                        <td style="text-align: center;">

                         <a href="../vistas/aprobar_practica_coordinacion_vista.php?cuenta=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                          <i class="fas fa-eye"  title=""  ></i>
                        </a>
                      </td>

                      <td style="text-align: center;">

                       <a href="../vistas/aprobar_practica_coordinacion_vista.php?cuenta_coordinacion=<?php echo $row['valor']; ?>" class="btn btn-primary btn-raised btn-xs">
                        <i class="fas fa-edit"  title=""  ></i>
                      </a>
                    </td>

                    <td style="text-align: center;">

                      <form class="well" action="../pdf/constancia_aprobacion_rechazo.php?id_persona=<?php echo $row['id']; ?>" method="POST" target="_blank">
                        <?php  
                          echo $btn_aprobacion;
                        ?>
                          <i class="zmdi zmdi-local-printshop"></i>
                    </td>
                    </form>

                  </tr>
                <?php  } 
              }?>
            </tbody>
          </table>
        </div>

        <!-- /.card-body -->
      </div>


      <div class="RespuestaAjax"></div>

    </div>
  </section>





</div>

<!--Creacion del modal-->

<!--<form action="../Controlador/aprobar_practica_coordinacion_controlador.php" method="post"  data-form="update" autocomplete="off"  >-->

<form action="../Controlador/aprobar_practica_coordinacion_controlador.php" method="post" data-form="save" id="formulario" autocomplete="off" class="FormularioAjax">

 <div class="modal fade" id="modal_aprobacion_practica">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Práctica  Profesional Supervisada</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?php 
          $cuenta=$_GET['cuenta_coordinacion'];
          $id=("select id_persona from tbl_personas_extendidas where valor='$cuenta'");
          $result= mysqli_fetch_assoc($mysqli->query($id));
          $id_persona=$result['id_persona'];
      ?>

      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">
          <div class="row">

            <div class="col-sm-6">
             <div class="form-group">
               <label>Estudiante</label>
               <input class="form-control" type="text" id="txt_estudiante_documento" name="txt_estudiante_documento" value="<?php echo strtoupper($_SESSION['txt_estudiante']) ?>" readonly="readonly">
             </div></div>

            <div class="col-sm-3">
             <div class="form-group">
               <label>Número de cuenta</label>
             <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" value="<?php echo strtoupper( $_SESSION['cuenta']) ?>" readonly="readonly">
             </div></div>


             <input class="form-control" type="text" id="txt_estudiante_id" name="txt_estudiante_id" hidden value="<?php echo strtoupper( $_SESSION['id_e']) ?>" readonly="readonly">


             <div class="col-sm-3">
             <div class="form-group">
               <label>Modalidad</label>
             <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" value="<?php echo strtoupper( $_SESSION['mod']) ?>" readonly="readonly">
             </div></div>

             <div class="col-sm-6">
             <div class="form-group">
               <label>Empresa</label>
             <input class="form-control" type="text" id="txt_empresa" name="txt_empresa" value="<?php echo strtoupper( $_SESSION['empresa']) ?>" readonly="readonly">
             </div></div>


              <div class="col-sm-6">
               <div class="form-group">
                <label>Horas Practica</label>
                <select class="form-control" name="cb_horas_practica" id="cb_horas_practica">
                  <option value="0">Seleccione una opción :</option>
                  <?php
                           $sql=$mysqli->query("SELECT * FROM tbl_horas");

                           while($fila=$sql->fetch_array()){
                              echo "<option value='".$fila['id_horas']."'>".$fila['descripcion']."</option>";
                           }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
                  <div class="form-group">
                  
                        <center> <h5>Fechas de PPS</h5></center>
                        
                        <center> <label for="cars">Fecha de inicio</label>  </center>
                        <input type="date" placeholder="Escribe tu nombre" name="fecha_inicio" class="form-control" id="fecha_inicio" required autofocus title="Ingresa tu nombre porfavor">
                        <center> <label>Días de Trabajo</label></center>
                          <select class="form-control"name="dias" id="dias">
                          <option value="">Seleccione una opción :</option>
                          <?php
                           $sql=$mysqli->query("SELECT * FROM tbl_dias_practica");

                           while($fila=$sql->fetch_array()){
                              echo "<option value='".$fila['id_dias']."'>".$fila['descripcion']."</option>";
                           }
                  ?>
                          </select>
                          <br>
                  </div>
            </div>

            <input hidden type="text" name="dias_practica" id="dias_practica" class="form-control">

            <div class="col-sm-4">
                <div class="form-group">
                          <center> <h5>Horario de Trabajo</h5></center>
                          <center> <label>Entrada</label> </center>
                          <input type="time" name="horario_incio" id="horario_incio" class="form-control" required autofocus title="Horario Entrada">
                          <center><label>Salida</label>  </center>
                    <input type="time" name="horario_fin" id="horario_fin" class="form-control" required autofocus title="Horario Salida">
                </div>
            </div>
            <div class="col-sm-4">
               <div class="form-group">
                         <center> <h5>Fecha de finalización de PPS</h5></center>
                         <center><label>Fecha</label>  </center>
                         <input type="date" placeholder="Escribe tu nombre" name="fecha_finalizacion" class="form-control" id="fecha_finalizacion"  autofocus title="Fecha Finalizacion PPS">
                         
              </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
               
                         <center><button type="button" id="btnEnviar" class="btn btn-primary" name="btnEnviar">Calcular Fecha</button></center>
                         
                    
              </div>
            </div>
            <div class="col-sm-12">
               <div class="form-group">
                <label>Aprobar PPS</label>
                <select class="form-control" name="cb_practica" id="cb_practica"  onchange="Mostrar_motivo();">
                  <option value="0">Seleccione una opción :</option>
                  <?php
                           $sql=$mysqli->query("SELECT * FROM tbl_estado_vinculacion");

                           while($fila=$sql->fetch_array()){
                              echo "<option value='".$fila['id_estado_vinculacion']."'>".$fila['descripcion']."</option>";
                           }
                  ?>
                </select>
             
              </div>

            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label>Motivo</label>
              </div></div>
              <div class="col-sm-12">
                <div class="form-group">
                 <textarea class="form-control" id="txt_motivo_rechazo" name="txt_motivo_rechazo" style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)"  rows="4" cols="50" required  minlength="20" >

                 </textarea>

               </div>
             </div>

             <div class="row">
       
          </div>

        </div>
      </div>
    </div>


   <input class="form-control" type="text" id="txt_estudiante_cuenta" name="txt_estudiante_cuenta" hidden="true"value="<?php echo strtoupper( $_SESSION['cuenta']) ?>" readonly="readonly">

    <!--Footer del modal-->
    <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-primary" id="btn_aprobacion_rechazo_practica" <?php echo $_SESSION['btn_aprobacion_rechazo_practica']; ?>>Guardar Cambios</button>
    </div>


  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
  <div class="RespuestaAjax"></div>

<!-- /.  final del modal -->


</form>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4 class="modal-title"></h4></center>
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<form action="" method="post"  data-form="update" autocomplete="off"  >



 <div class="modal fade" id="modal_documentacion_estudiante">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de Documentación </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>




      <!--Cuerpo del modal-->
      <div class="modal-body">
        <div class="card-body">

          <label>Estudiante</label>
          <input class="form-control" type="text" id="txt_estudiante" name="txt_estudiante" value="<?php echo strtoupper($_SESSION['txt_estudiante']) ?>" readonly="readonly">


          <ul>
            <?php echo $listar ?>

          </ul>
        </div>
      </div>




      <!--Footer del modal-->
      <div class="modal-footer justify-content-between">

      </div>


    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="RespuestaAjax"></div>

<!-- /.  finaldel modal -->


</form>


<script type="text/javascript" src="../js/calculo_fecha_pps.js"></script>

<script type="text/javascript">


 $(function () {

  $('#tabla').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
  });
});


</script>

<script type="text/javascript">



$(document).ready(function () {

    $('#btnEnviar').on('click', function () {

        var url = "../Controlador/calculo_fecha_pps_controlador.php?op=fecha";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formulario").serialize(),
            success: function (data) {
                $("#fecha_finalizacion").val(data);

            }
        });
    });
});

//motivo rechazo PPS

$('#txt_motivo_rechazo').prop("readonly", true);


function Mostrar_motivo()
{
  /* Para obtener el valor */
  var aprobar = document.getElementById("cb_practica").value;


 if(aprobar == "3" || aprobar =="2") {
   
    $('#txt_motivo_rechazo').prop("readonly", false);
   document.getElementById("txt_motivo_rechazo").value = "";

 }
 else

  {
    $('#txt_motivo_rechazo').prop("readonly", true);
  }

}




</script>



</body>

</html>
