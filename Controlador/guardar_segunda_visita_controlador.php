<?php
require_once "../Modelos/segunda_visita_modelo.php";

$modelo=new segunda_visita();


$numero_cuenta=isset($_POST["cuenta_sv"])? ($_POST["cuenta_sv"]):"";
$adaptacion=isset($_POST["adaptacion_sv"])? ($_POST["adaptacion_sv"]):"";
$lenguaje=isset($_POST["lenguaje_sv"])? ($_POST["lenguaje_sv"]):"";
$capacidad=isset($_POST["capacidad_sv"])? ($_POST["capacidad_sv"]):"";
$cumplimiento=isset($_POST["cumplimiento_sv"])? ($_POST["cumplimiento_sv"]):"";
$responsabilidad=isset($_POST["responsabilidad_sv"])? ($_POST["responsabilidad_sv"]):"";
$capacidadIA=isset($_POST["capacidadIA_sv"])? ($_POST["capacidadIA_sv"]):"";
$disposicion=isset($_POST["disposicion_sv"])? ($_POST["disposicion_sv"]):"";
$liderazgo=isset($_POST["liderazgo_sv"])? ($_POST["liderazgo_sv"]):"";
$resolucion=isset($_POST["resolucion_sv"])? ($_POST["resolucion_sv"]):"";
$tomadesiciones=isset($_POST["tomadecisiones_sv"])? ($_POST["tomadecisiones_sv"]):"";
$proactividad=isset($_POST["proactividad_sv"])? ($_POST["proactividad_sv"]):"";
$planificacion=isset($_POST["planificacion_sv"])? ($_POST["planificacion_sv"]):"";
$calidad=isset($_POST["calidad_sv"])? ($_POST["calidad_sv"]):"";
$presentacion=isset($_POST["presentacion_sv"])? ($_POST["presentacion_sv"]):"";
$participacion=isset($_POST["participacion_sv"])? ($_POST["participacion_sv"]):"";
$aplicacion=isset($_POST["aplicacion_sv"])? ($_POST["aplicacion_sv"]):"";
$creacion=isset($_POST["creacion_sv"])? ($_POST["creacion_sv"]):"";
$actualizacion=isset($_POST["actualizacion_sv"])? ($_POST["actualizacion_sv"]):"";
$comentario=isset($_POST["otrasobservaciones_sv"])? ($_POST["otrasobservaciones_sv"]):"";
$area_refuerzo=isset($_POST["areas_refuerzo_sv"])? ($_POST["areas_refuerzo_sv"]):"";
$calificacion=isset($_POST["calificacion_sv"])? ($_POST["calificacion_sv"]):"";
$solicitar=isset($_POST["solicitar_practicante_sv"])? ($_POST["solicitar_practicante_sv"]):"";
$representante=isset($_POST["representante_sv"])? ($_POST["representante_sv"]):"";
$supervisor=isset($_POST["supervisor_sv"])? ($_POST["supervisor_sv"]):"";
$lugar=isset($_POST["lugar_sv"])? ($_POST["lugar_sv"]):"";
$oportunidad=isset($_POST["casono_sv"])? ($_POST["casono_sv"]):"";
$id_persona=isset($_POST["id_persona"])? ($_POST["id_persona"]):"";




$prueba="selectCurso";




switch ($_GET["op"]){
	case 'guardar':
		
            $rspta=$modelo->insertar($numero_cuenta, $adaptacion, $lenguaje, $capacidad, $cumplimiento, $responsabilidad, $capacidadIA, $disposicion, $liderazgo, $resolucion, $tomadesiciones, $proactividad, $planificacion, $calidad,
            $presentacion, $participacion, $aplicacion, $creacion, $actualizacion, $comentario, $area_refuerzo, $calificacion, $solicitar, $representante, $supervisor, $lugar, $oportunidad, $id_persona);
			echo $rspta ? "Encuesta registrada con exito" : "La encuesta no se pudo registrar";
		
	break;

    case 'selectCurso':
		$rspta=$modelo->selectCurso();
        while ($r = mysqli_fetch_array($rspta)) {
            echo '<option value="'.$r['id_persona'].' "  >'.$r['nombres']. ' ' .$r['apellidos']. '</option>';

        }


        break;

    
        
    case 'rellenarDatos':
$rspta=$modelo->rellenarDatos($id_persona);
echo json_encode($rspta);
break;




	
}
?>
