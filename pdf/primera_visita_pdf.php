<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$connection->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

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
    // Cabecera de página
	function Header()
    {
		// Logo
        $this->Image('../dist/img/logo.png',30,12,28);
        // Arial bold 15
        $this->SetFont('Arial','I',8);
        $this->SetFillColor(255, 255, 255);;
        // Movernos a la derecha
        $this->Rect(0,0,220,50,'F');
        $this->Image('../dist/img/psp.png',10,12,195);
        // Título
		$this->SetY(20);
        $this->SetX(166);
        $this->Write(15,utf8_decode('15/10/2021'));
        $this->SetY(32);
        $this->SetX(186);
        $this->SetFont('Arial','I',8);
        $this->SetY(27);
        $this->SetX(185);
        $this->Write(15,utf8_decode('1.0'));
        $this->SetY(35);
        $this->SetX(165);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');

        $this->Ln(20);
    }
} 
//date_default_timezone_get('America/Tegucigalpa');
if (isset($_GET['id']) ) {
	$id_persona=$_GET['id'];

	$sql = "SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombres, a.identidad, ep.nombre_empresa, ep.direccion_empresa, vap.fecha_inicio, vap.fecha_finalizacion, m.modalidad, dp.descripcion AS horario, concat(vap.horario_entrada,' a ',vap.horario_salida) as horas, c.valor Correo, e.valor Celular, cp.nombre, na.descripcion as nivel_a, cp.cargo, cp.correo, cp.telefono, cp.celular, a.id_persona, ca.nombre_representante,ca.supervisor, concat(ca.lugar,' ',ca.fecha) AS lugar_fecha, evp.comunicacion, evp.puntualidad, evp.responsabilidad, evp.creatividad, evp.presentacion, evp.atencion_cliente, evp.colaborativo, evp.trabajo_equipo, evp.proactivo_iniciativa, evp.relacion_interpersonal, evp.relacion_interpersonal, evp.analisis_sistema, evp.diseno_aplicacion, evp.programador_aplicacion, fp.funciones_analisis, fp.funciones_redes, fp.funciones_diseno, fp.funciones_capacitacion, fp.funciones_seguridad, fp.funciones_auditoria, fp.funciones_base, fp.funciones_soporte, fp.funciones_programacion, fp.otras_funciones
        FROM

        tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        JOIN tbl_vinculacion_aprobacion_practica AS  vap ON vap.id_persona = a.id_persona
        JOIN tbl_contacto_practica AS cp ON cp.persona_id = a.id_persona
        JOIN tbl_nivel_academico AS na ON na.id_nivel_a = cp.nivel_academico
        JOIN tbl_modalidad AS m ON m.id_modalidad = pe.id_modalidad
        JOIN tbl_dias_practica AS dp ON dp.id_dias = vap.id_dias
        JOIN tbl_comentarios_alumnos AS ca ON ca.id_persona = '$id_persona'
        JOIN tbl_funciones_practica AS fp ON fp.id_persona = '$id_persona'
        JOIN tbl_evaluaciones_practica AS evp ON evp.id_persona = '$id_persona'
        JOIN tbl_personas_extendidas AS px ON px.id_persona=a.id_persona and pe.id_persona='$id_persona' and fp.numero_visita='Primera Supervisión' and ca.numero_visita='Primera Supervisión' and evp.numero_visita='Primera Supervisión' and a.id_persona='$id_persona' AND ep.contacto_id = cp.id";

        $row= mysqli_fetch_assoc($mysqli->query($sql));

	
	$pdf = new PDF('P','mm','letter',true);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
    $pdf->Image('../dist/img/parte01_psp.png',3,45,208);
	$pdf->SetFont('Arial','',10);
	$pdf->ln(2);
    $pdf->SetX(100);
	$pdf->SetY(71);
	$pdf->Cell(122, 10, utf8_decode(''.$row['nombres'].''), 0, 1, 'C');
	$pdf->SetY(80);
	$pdf->Cell(99, 10, utf8_decode(''.$row['identidad'].''), 0, 1, 'C');
	$pdf->SetY(108);
	$pdf->Cell(80, 10, utf8_decode(''.$row['nombre_empresa'].''), 0, 1, 'C');
	$pdf->SetY(117);
	$pdf->Cell(99, 10, utf8_decode(''.$row['direccion_empresa'].''), 0, 1, 'C');
	$pdf->SetY(71);
	$pdf->Cell(332, 10, utf8_decode(''.$row['valor'].''), 0, 1, 'C');
	$pdf->SetY(173);
	$pdf->Cell(80, 10, utf8_decode(''.$row['modalidad'].''), 0, 1, 'C');
	$pdf->SetY(183);
	$pdf->Cell(87, 10, utf8_decode(''.fecha($row['fecha_inicio'].'')), 0, 1, 'C');
	$pdf->SetY(183);
	$pdf->Cell(295, 10, utf8_decode(''.fecha($row['fecha_finalizacion'].'')), 0, 1, 'C');
	$pdf->SetY(192);
	$pdf->Cell(102, 10, utf8_decode(''.$row['horario'].''), 0, 1, 'C');
	$pdf->SetY(192);
	$pdf->Cell(300, 10, utf8_decode(''.$row['horas'].''), 0, 1, 'C');
	$pdf->SetY(89);
	$pdf->Cell(103, 10, utf8_decode(''.$row['Correo'].''), 0, 1, 'C');
	$pdf->SetY(80);
	$pdf->Cell(325, 10, utf8_decode(''.$row['Celular'].''), 0, 1, 'C');
	$pdf->SetY(136);
	$pdf->Cell(98, 10, utf8_decode(''.$row['nombre'].''), 0, 1, 'C');
	$pdf->SetY(145);
	$pdf->Cell(329, 10, utf8_decode(''.$row['nivel_a'].''), 0, 1, 'C');
	$pdf->SetY(136);
	$pdf->Cell(326, 10, utf8_decode(''.$row['cargo'].''), 0, 1, 'C');
	$pdf->SetY(145);
	$pdf->Cell(107, 10, utf8_decode(''.$row['correo'].''), 0, 1, 'C');
	$pdf->SetY(154);
	$pdf->Cell(86, 10, utf8_decode(''.$row['telefono'].''), 0, 1, 'C');
	$pdf->SetY(154);
	$pdf->Cell(328, 10, utf8_decode(''.$row['celular'].''), 0, 1, 'C');
	$pdf->SetY(205);
	$pdf->SetX(45);
	$pdf->multicell(170, 5, utf8_decode(' '.$row['funciones_analisis'].' 
	 '.$row['funciones_redes'].'              
	 '.$row['funciones_diseno'].' 
	 '.$row['funciones_capacitacion'].' 
	 '.$row['funciones_seguridad'].'
	 '.$row['funciones_auditoria'].'
	 '.$row['funciones_base'].' 
	 '.$row['funciones_soporte'].' 
	 '.$row['funciones_programacion'].' 
	 '.$row['otras_funciones'].'.'), 0);


	for($i = 0; $i < 4; $i++){
		if($i == 1){
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte02_psp.png',3,45,208);
			$pdf->ln(2);
			$pdf->SetY(104);
			$pdf->Cell(300, 10, ''.$row['comunicacion'].'', 0, 1, 'C');
			$pdf->SetY(113);
			$pdf->Cell(300, 10, ''.$row['puntualidad'].'', 0, 1, 'C');
			$pdf->SetY(122);
			$pdf->Cell(300, 10, ''.$row['responsabilidad'].'', 0, 1, 'C');
			$pdf->SetY(131);
			$pdf->Cell(300, 10, ''.$row['creatividad'].'', 0, 1, 'C');
			$pdf->SetY(140);
			$pdf->Cell(300, 10, ''.$row['presentacion'].'', 0, 1, 'C');
			$pdf->SetY(149);
			$pdf->Cell(300, 10, ''.$row['atencion_cliente'].'', 0, 1, 'C');
			$pdf->SetY(158);
			$pdf->Cell(300, 10, ''.$row['programador_aplicacion'].'', 0, 1, 'C');
			$pdf->SetY(177);
			$pdf->Cell(300, 10, ''.$row['colaborativo'].'', 0, 1, 'C');
			$pdf->SetY(186);
			$pdf->Cell(300, 10, ''.$row['trabajo_equipo'].'', 0, 1, 'C');
			$pdf->SetY(195);
			$pdf->Cell(300, 10, ''.$row['proactivo_iniciativa'].'', 0, 1, 'C');
			$pdf->SetY(204);
			$pdf->Cell(300, 10, ''.$row['relacion_interpersonal'].'', 0, 1, 'C');
			$pdf->SetY(213);
			$pdf->Cell(300, 10, ''.$row['analisis_sistema'].'', 0, 1, 'C');
			$pdf->SetY(222);
			$pdf->Cell(300, 10, ''.$row['diseno_aplicacion'].'', 0, 1, 'C');
			$pdf->SetY(241);
			$pdf->Cell(300, 10, ''.$row['lugar_fecha'].'', 0, 1, 'C');
		}if($i == 2){
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte03_psp.png',3,45,208);
			$pdf->ln(2);
			$pdf->SetY(50);
			$pdf->Cell(300, 10, ''.$row['nombre_representante'].'', 0, 1, 'C');
			$pdf->SetY(71);
			$pdf->Cell(300, 10, ''.$row['supervisor'].'', 0, 1, 'C');
		}
	}
}
	$pdf->Output();


?>