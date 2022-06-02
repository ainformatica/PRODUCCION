<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$sql = "SELECT concat(p.nombres,' ',p.apellidos) as nombre, ep.nombre_empresa, m.modalidad, ev.descripcion as estado, h.descripcion as horas, vp.fecha_inicio, vp.fecha_finalizacion, concat(dp.descripcion,' DE ',vp.horario_entrada,' A ',vp.horario_salida) as horario  from  tbl_personas p,tbl_empresas_practica ep ,tbl_personas_extendidas px, tbl_practica_estudiantes pe, tbl_modalidad m, tbl_vinculacion_aprobacion_practica vp,tbl_estado_vinculacion ev, tbl_horas h, tbl_dias_practica dp where m.id_modalidad=pe.id_modalidad AND vp.id_estado_vinculacion=ev.id_estado_vinculacion AND vp.id_horas=h.id_horas AND vp.id_dias=dp.id_dias AND px.id_atributo=12 and px.id_persona=p.id_persona AND vp.id_persona=p.id_persona and p.id_persona=$_SESSION[id]";

function fechaCastellano ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
  $meses_ES = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia." de ".$nombreMes." del ".$anio;
  }

  function fecha ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    return $numeroDia."-".$mes."-".$anio;
  }

date_default_timezone_set('America/Tegucigalpa');
        $fecha = date('Y-m-d');


class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		    $this->Image('../dist/img/logos.png', 20,8,98);
			$this->Ln(30);
		}

}
// date_default_timezone_get('America/Tegucigalpa');

    $resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);
	

	$pdf = new PDF('P','mm','Legal',true);
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(22);
	$pdf->Image('../dist/img/fondo.png',1,146,217);
    $pdf->SetX(22);
	$pdf->cell(0,6,utf8_decode('Buenos días, '.$row['nombre'].'.'),0,1,'L');
	$pdf->ln(3);
    $pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(22);
    $pdf->multicell(175,6,utf8_decode('Un placer saludarle, deseándole abundantes éxitos y excelente salud considerando la actual crisis sanitaria. Por este medio el Comité de Vinculación Universidad - Sociedad del Departamento de Informática - UNAH, le informa que '.$row['estado'].' su Práctica Profesional Supervisada, la cual se concede bajo los términos siguientes:'),0);

    $pdf->Image('../dist/img/cuadro_aprobacion.png',20,73,170);
	$pdf->SetY(73);
	$pdf->Cell(128, 10, ''.$row['nombre_empresa'].'', 0, 1, 'C');
	$pdf->ln(-3);
	$pdf->SetY(82);
	$pdf->Cell(128, 10, utf8_decode(''.$row['modalidad'].''), 0, 1, 'C');
	$pdf->ln(-3);
	$pdf->SetY(91);
	$pdf->Cell(136, 10, utf8_decode(''.fecha($row['fecha_inicio'].'')), 0, 1, 'C');
	$pdf->ln(-3);
	$pdf->SetY(100);
	$pdf->Cell(136, 10, utf8_decode(''.fecha($row['fecha_finalizacion'].'')), 0, 1, 'C');
	$pdf->ln(-3);
	$pdf->SetY(109);
	$pdf->Cell(187, 10, utf8_decode(''.$row['horario'].''), 0, 1, 'C');
	$pdf->ln(1);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Usted no puede terminar su práctica antes de la fecha señalada, ni realizar cambios sin previa consulta al comité; de lo contrario, no será considerada como válida. Las fechas antes descritas son definitivas y no se encuentran condicionadas a actualización o recorte de tiempo por el hecho de realizar horas extras, pues estas son parte inherente del ámbito laboral en el cual se desempeñará.'),0);
    $pdf->ln(3);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('El tiempo total de la práctica profesional, se calculó con base al horario exceptuando los feriados oficiales, haciendo un total de '.$row['horas'].' horas. Cualquier cambio, o situación anómala, debe ser reportado lo más pronto posible al Comité de Vinculación del Departamento de Informática mediante carta y una copia al correo electrónico.'),0);
	$pdf->ln(3);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Transcurrido un mes, si no ha recibido notificación de su supervisor, usted deberá avocarse al comité al correo electrónico supervisionpps.dia@unah.edu.hn, para que se le asigne uno, quien hará la primera visita según estime conveniente; y una segunda visita, un mes antes de finalizar su Práctica Profesional.  En caso de no hacerse las dos supervisiones, no será posible realizar el trámite de la Constancia de Finalización de Práctica Profesional, y, por ende, tampoco del resto de la documentación para su graduación.'),0);
	$pdf->ln(3);
	$pdf->SetX(22);
	$pdf->multicell(170,6,utf8_decode('Finalizado su proceso de práctica profesional, debe acreditar (enviar vía correo electrónico a pps.dia@unah.edu.hn) un "INFORME DE PRÁCTICA PROFESIONAL" (validado por su jefe inmediato con firma y sello) y la respectiva "CONSTANCIA DE FINALIZACIÓN" (se le adjunta la estructura del informe y el formato de dicha constancia, siendo ambos de obligatorio cumplimiento). Cabe destacar que su supervisor asignado podrá solicitarle evidencias del trabajo realizado mientras desarrolla su Práctica Profesional, a fin de realizar el aseguramiento de la calidad de la misma, contando con las atribuciones para cancelar la Práctica Profesional ante anomalías que puedan ser evidenciadas. Recuerde guardar los documentos originales para ser entregados de manera física al Departamento de Informática y enviar por correo su Constancia de Finalización de Práctica Profesional para realizar una revisión de la misma.'),0);
	$pdf->ln(3);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Saludos cordiales.'),0);
	$pdf->ln(16);
	$pdf->Image('../dist/img/Sello.png',55,298,25);
	$pdf->Image('../dist/img/firma.png',81,300,40);
	$pdf->SetFont('Times','BI',14);
	$pdf->cell(0,6,utf8_decode('Cristian Josué Rivera Ramírez'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Times','I',14);
	$pdf->cell(0,6,utf8_decode('Coordinador de Comité de Vinculación Universidad - Sociedad'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');


	$pdf->Output();

?>