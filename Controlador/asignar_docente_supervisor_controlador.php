<?php
ob_start();
require_once "../Modelos/asignar_docente_supervisor_modelo.php";
require_once ('corre_supervisor.php');

$modelo=new asignaturas();
$id_supervisor=isset($_POST["id_supervisor"])? $instancia_conexion->limpiarCadena($_POST["id_supervisor"]):"";
$nombre_alumno=isset($_POST["nombre_alumno"]);
$cuenta=isset($_POST["cuenta"]);
$docente=isset($_POST["docente"])? $instancia_conexion->limpiarCadena($_POST["docente"]):"";

$correo= new correo();


switch ($_GET["op"]){

	

	// case 'editar':

	// 		$rspta=$modelo->editar($docente,$id_supervisor);
	// 	    "UPDATE tbl_practica_estudiantes SET docente_supervisor = $docente;"
	

	// break;

	case 'desactivar':
		$rspta=$modelo->desactivar($id_asignatura);
 		echo $rspta ? "Asignatura Desactivada con exito" : "Asignatura no se puede desactivar";
 		break;

	case 'activar':
		$rspta=$modelo->activar($id_asignatura);
 		echo $rspta ? "Asignatura activada con exito" : "Asignatura no se puede activar";
 		break;

	case 'mostrar':
		$rspta=$modelo->mostrar($id_supervisor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;

	case 'listar':
		$rspta=$modelo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

			 $estado="";
			 $botones='<center><div class="input-group mr-2" ><form  action="../vistas/docente_supervisor_vista.php?id_persona='.$reg->id_persona.'" method="post"><button class="btn btn-primary btn-raised btn-sm" onclick="mostrar('.$reg->id_persona.')" name="id_asignatura" value="'.$reg->id_persona.'"> <i class="fa fa-edit"></i> </button></form></div></center>';



 			$data[]=array(

 				"0"=>$botones,
       			"1"=>$reg->nombre,
 				"2"=>$reg->valor,
				"3"=>$reg->nombre_empresa,
				"4"=>$reg->direccion_empresa,
				"5"=>$reg->fecha_inicio,
				"6"=>$reg->fecha_finalizacion,
				"7"=>$reg->id_persona


 				);
		 }

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

}

ob_end_flush();
?>
