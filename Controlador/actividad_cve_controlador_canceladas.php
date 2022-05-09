<?php 
ob_start();
session_start();

require_once "../Modelos/actividad_cve_modelo.php";
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_bitacora.php');

$actividad=new Actividad();
$Id_objeto=8235;
$usuario= $_SESSION['id_usuario'];

$id_actividad_voae=isset($_POST["id_actividad_voae"])? $instancia_conexion->limpiarCadena($_POST["id_actividad_voae"]):"";
$id_actividad=isset($_POST["id_actividad"])? $instancia_conexion->limpiarCadena($_POST["id_actividad"]):"";
$just_act=isset($_POST["just_act"])? $instancia_conexion->limpiarCadena($_POST["just_act"]):"";
$no_solicitud=isset($_POST["no_solicitud"])? $instancia_conexion->limpiarCadena($_POST["no_solicitud"]):"";
//$fch_solicitud=isset($_POST["fch_solicitud"])? $instancia_conexion->limpiarCadena($_POST["fch_solicitud"]):"";
$nombre_actividad=isset($_POST["nombre_actividad"])? $instancia_conexion->limpiarCadena($_POST["nombre_actividad"]):"";
$ubicacion=isset($_POST["ubicacion"])? $instancia_conexion->limpiarCadena($_POST["ubicacion"]):"";
$fch_inicial_actividad=isset($_POST["fch_inicial_actividad"])? $instancia_conexion->limpiarCadena($_POST["fch_inicial_actividad"]):"";
$fch_final_actividad=isset($_POST["fch_final_actividad"])? $instancia_conexion->limpiarCadena($_POST["fch_final_actividad"]):"";
$descripcion=isset($_POST["descripcion"])? $instancia_conexion->limpiarCadena($_POST["descripcion"]):"";
$poblacion_objetivo=isset($_POST["poblacion_objetivo"])? $instancia_conexion->limpiarCadena($_POST["poblacion_objetivo"]):"";
$presupuesto=isset($_POST["presupuesto"])? $instancia_conexion->limpiarCadena($_POST["presupuesto"]):"";
$staff_alumnos=isset($_POST["staff_alumnos"])? $instancia_conexion->limpiarCadena($_POST["staff_alumnos"]):"";
$observaciones=isset($_POST["observaciones"])? $instancia_conexion->limpiarCadena($_POST["observaciones"]):"";
//$id_estado=isset($_POST["id_estado"])? $instancia_conexion->limpiarCadena($_POST["id_estado"]):"";
//$id_usuario_registro=isset($_POST["id_usuario_registro"])? $instancia_conexion->limpiarCadena($_POST["id_usuario_registro"]):"";
$id_ambito=isset($_POST["id_ambito"])? $instancia_conexion->limpiarCadena($_POST["id_ambito"]):"";
$periodo=isset($_POST["periodo"])? $instancia_conexion->limpiarCadena($_POST["periodo"]):"";


if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_aprobar"]="hidden";
  } else {
    $_SESSION["btn_aprobar"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)=='0')    {
    $_SESSION["btn_denegar"]="hidden";
  } else {
    $_SESSION["btn_denegar"]="";
  }




switch ($_GET["op"]){
	
	case 'denegar':
		$sql = "select id_actividad_voae, id_estado from tbl_voae_actividades where id_actividad_voae = '$id_actividad'";
	    $result_valor = $mysqli->query($sql);
	    $estado = $result_valor->fetch_array(MYSQLI_ASSOC);

	  if  ($estado['id_estado'] == 4){
				echo 'La actividad ya ha sido denegada';
				
		} else {

 		$rspta=$actividad->denegar($id_actividad,$just_act);
 		echo $rspta ? "Actividad Denegada" : "La actividad no se puede Denegar";
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'DENEGO', 'EL No DE SOLICITUD DE ACTIVIDAD "' . $estado['id_actividad_voae'] . '"');
 		}
	break;



	case 'aprobar':

		$rspta=$actividad->aprobar($id_actividad_voae);
 		echo $rspta ? "Actividad Aprobada" : "Actividad no se puede aprobar";

 		$valor = "select id_actividad_voae from tbl_voae_actividades where id_actividad_voae = '$id_actividad_voae'";
	    $result_valor = $mysqli->query($valor);
	    $bt_no_solicitud = $result_valor->fetch_array(MYSQLI_ASSOC);

 		//SE MANDA A LA BITACORA LA ACCION DE enviar la actividad
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'APROBO', 'EL No DE SOLICITUD"' . $bt_no_solicitud['id_actividad_voae'] . '"');
	break;

	case 'mostrar':

		$rspta=$actividad->mostrar2($id_actividad_voae);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'mostrar2':

		$rspta=$actividad->mostrar($id_actividad_voae);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'listar3':
		$rspta=$actividad->listar3($usuario);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button title="Ver Datos Actividad" class="btn btn-warning"onclick="mostrar('.$reg->id_actividad_voae.',1)"><i class="far fa-eye"></i></button>'.
 				'<button id="btn_denegar"title="Ver Motivo Cancelación " class="btn btn-danger pull-right"  '.$_SESSION["btn_denegar"].' onclick="mostrar2('.$reg->id_actividad_voae.')"><i class="fa fa-info"></i></button>',
 				"1"=>$reg->id_actividad_voae,
 				"2"=>$reg->nombre_actividad,
 				"3"=>$reg->periodo

 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
}
  ob_end_flush();
?>

