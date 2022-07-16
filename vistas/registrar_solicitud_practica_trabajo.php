<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 6002;




$visualizacion = permiso_ver($Id_objeto);

$usuario = $_SESSION['id_usuario'];
$id = ("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result = mysqli_fetch_assoc($mysqli->query($id));
$id_persona = $result['id_persona'];
$sql_estudiante = ("SELECT tbl4.id_persona,tbl4.identidad, concat(tbl4.nombres,' ',tbl4.apellidos) as Nombre, 
tbl4.fecha_nacimiento, tbl5.valor Cuenta from tbl_personas tbl4
INNER join tbl_personas_extendidas tbl5
on tbl4.id_persona=tbl5.id_persona
where tbl4.id_persona=$id_persona");

$sql_estudianteInfo = ("SELECT tb1.*,tb2.descripcion FROM tbl_contactos tb1
left join tbl_tipo_contactos tb2
on tb1.id_tipo_contacto=tb2.id_tipo_contacto
where id_persona=$id_persona");

//Obtener la fila del query
$datos_estudiante = mysqli_fetch_assoc($mysqli->query($sql_estudiante));








if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_estudiantes_practica_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A REGISTRAR SOLICITUD PRACTICA.');


  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_solicitud_pps'] = "";
  } else {
    $_SESSION['btn_guardar_solicitud_pps'] = "disabled";
  }
}


ob_end_flush();




?>


<!DOCTYPE html>
<html>

<head>
  <title></title>
  <link rel="stylesheet" href="../css/tabs_formulario_pps.css">
</head>

<body>


<div class="container ">


<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1">Información del Estudiante</label>
  <!-- Tab 2 -->
  

  <div class="tab-panels container">
        <!-- INFORMACION PERSONAL -->
    <section id="marzen" class="tab-panel">
      <form id='frmPracticaTrabajo' method="post" action="../api/registrar_empresa.php" enctype="multipart/form-data">
        
      <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <label>Nombre Completo</label>
                  <input class="form-control" type="text" id="txt_nombre" name="txt_cuenta_soli" maxlength="12" value="<?php echo $datos_estudiante['Nombre'];; ?>" readonly>
                  <input class="form-control" type="hidden" id="txt" name="idpersona_solicita" maxlength="120" value="<?php echo $id_persona?>" readonly>
               
                  
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Nº de Cuenta</label> 

                  <input class="form-control" type="text" id="txt_valor" name="cuenta" maxlength="12" value="<?php echo $datos_estudiante['Cuenta']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label>DNI</label>
                  <input class="form-control" type="text" id="txt_identidad" name="txt_dni" maxlength="12" value="<?php echo $datos_estudiante['identidad']; ?>" readonly>
                </div>
            </div>
        
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Fecha de nacimiento</label>
                  <input class="form-control" type="text" id="txt_fecha" name="txt_fechaa" maxlength="12" value="<?php echo $datos_estudiante['fecha_nacimiento']; ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                  <div class="form-group">
                    <label>Subir carta de practica por trabajo</label>
                    <input class="form-control" type="file" id="txt_solicitud" name="m_solicitud">
                  </div>
                </div>

            <div class="col-sm-12 ">
                <div class="form-group">
                  <button class="btn btn-primary">Guardar</button>
                  <button class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
        
      </form>
    </section>

  </div>
  

  <script src="../js/charla/practicaportrabajo.js"></script>
  
<script>
    $('input[type="file"]').on('change', function() {
      var ext = $(this).val().split('.').pop();
      if ($(this).val() != '') {
        if (ext == "pdf" || ext == "PDF") {
          if ($(this)[0].files[0].size > 1048576) {
            swal({
              title: "",
              text: "excede el tamaño permitido...",
              type: "error",
              showConfirmButton: false,
              timer: 2000
            });

            $(this).val('');
          }
        } else {
          $(this).val('');
          swal({
            title: "",
            text: "Extensión no permitida: " + ext,
            type: "error",
            showConfirmButton: false,
            timer: 2000
          });
        }
      }
    });
  </script>

<?php
if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos  se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';
  }
  if ($msj == 2) {


    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Error al actualizar lo sentimos,intente de nuevo.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';
  }
  if ($msj == 3) {
    echo '<script type="text/javascript">
                                                  swal({
                                                       title:"",
                                                       text:"Ya tienes una solicitud.",
                                                       type: "info",
                                                       showConfirmButton: false,
                                                       timer: 3000
                                                    });

                                                </script>';
  }
}
?>
</body>

</html>