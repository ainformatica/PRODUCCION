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
        $this->Image('../dist/img/ssp.png',10,12,195);
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

	$sql = "SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombres, a.identidad, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, m.modalidad, dpr.descripcion AS horario, concat(vap.horario_entrada,' a ',vap.horario_salida) as horas, c.valor Correo, e.valor Celular, ep.jefe_inmediato, na.descripcion as nivel_a, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.celular_jefe_inmediato, a.id_persona, ca.comentario_evaluacion, ca.area_refuerzo, ca.calificacion_global, ca.solicitar_practicante, ca.oportunidad_empleo, ca.nombre_representante, ca.supervisor, concat(ca.lugar,' ',ca.fecha) AS lugar_fecha, dp.adaptacion, dp.lenguaje, dp.capacidad, dp.cumplimiento, dp.responsabilidad, dp.capacidadIA, dp.disposicion, dp.liderazgo, dp.resolucion, dp.tomadecisiones, dp.proactividad, dp.planificacion, dp.calidad, dp.presentacion, dp.participacion, dp.aplicacion, dp.creacion, dp.actualizacion
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
        JOIN tbl_nivel_academico AS na ON na.id_nivel_a = ep.id_nivel_a
        JOIN tbl_modalidad AS m ON m.id_modalidad = pe.id_modalidad
        JOIN tbl_dias_practica AS dpr ON dpr.id_dias = vap.id_dias
        JOIN tbl_comentarios_alumnos AS ca ON ca.id_persona = '$id_persona'
        JOIN tbl_desempeno_practica AS dp ON dp.id_persona = '$id_persona'
        JOIN tbl_personas_extendidas AS px ON px.id_persona=a.id_persona and pe.id_persona='$id_persona' and ca.numero_visita='Segunda Supervisión' and dp.numero_visita='Segunda Supervisión'";

        $row= mysqli_fetch_assoc($mysqli->query($sql));

	
	$pdf = new PDF('P','mm','letter',true);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
    $pdf->Image('../dist/img/parte01_ssp.png',3,45,208);
	$pdf->SetFont('Arial','',10);
	$pdf->ln(2);
    $pdf->SetX(100);
	$pdf->SetY(67);
	$pdf->Cell(122, 10, utf8_decode(''.$row['nombres'].''), 0, 1, 'C');
	$pdf->SetY(76);
	$pdf->Cell(99, 10, utf8_decode(''.$row['identidad'].''), 0, 1, 'C');
	$pdf->SetY(104);
	$pdf->Cell(80, 10, utf8_decode(''.$row['nombre_empresa'].''), 0, 1, 'C');
	$pdf->SetY(113);
	$pdf->Cell(99, 10, utf8_decode(''.$row['direccion_empresa'].''), 0, 1, 'C');
	$pdf->SetY(67);
	$pdf->Cell(332, 10, utf8_decode(''.$row['valor'].''), 0, 1, 'C');
	$pdf->SetY(169);
	$pdf->Cell(80, 10, utf8_decode(''.$row['modalidad'].''), 0, 1, 'C');
	$pdf->SetY(180.5);
	$pdf->Cell(87, 10, utf8_decode(''.fecha($row['fecha_inicio'].'')), 0, 1, 'C');
	$pdf->SetY(180.5);
	$pdf->Cell(295, 10, utf8_decode(''.fecha($row['fecha_finalizacion'].'')), 0, 1, 'C');
	$pdf->SetY(192);
	$pdf->Cell(102, 10, utf8_decode(''.$row['horario'].''), 0, 1, 'C');
	$pdf->SetY(192);
	$pdf->Cell(300, 10, utf8_decode(''.$row['horas'].''), 0, 1, 'C');
	$pdf->SetY(85);
	$pdf->Cell(103, 10, utf8_decode(''.$row['Correo'].''), 0, 1, 'C');
	$pdf->SetY(76);
	$pdf->Cell(325, 10, utf8_decode(''.$row['Celular'].''), 0, 1, 'C');
	$pdf->SetY(132);
	$pdf->Cell(98, 10, utf8_decode(''.$row['jefe_inmediato'].''), 0, 1, 'C');
	$pdf->SetY(141);
	$pdf->Cell(329, 10, utf8_decode(''.$row['nivel_a'].''), 0, 1, 'C');
	$pdf->SetY(132);
	$pdf->Cell(326, 10, utf8_decode(''.$row['cargo_jefe_inmediato'].''), 0, 1, 'C');
	$pdf->SetY(141);
	$pdf->Cell(107, 10, utf8_decode(''.$row['correo_jefe_inmediato'].''), 0, 1, 'C');
	$pdf->SetY(150);
	$pdf->Cell(86, 10, utf8_decode(''.$row['telefono_jefe_inmediato'].''), 0, 1, 'C');
	$pdf->SetY(150);
	$pdf->Cell(328, 10, utf8_decode(''.$row['celular_jefe_inmediato'].''), 0, 1, 'C');


	for($i = 0; $i < 4; $i++){
		if($i == 1){
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte02_ssp.png',3,45,208);
			$pdf->ln(2);
			$pdf->SetY(45);
			$pdf->Cell(300, 10, ''.$row['adaptacion'].'', 0, 1, 'C');
			$pdf->SetY(54);
			$pdf->Cell(300, 10, ''.$row['lenguaje'].'', 0, 1, 'C');
			$pdf->SetY(63);
			$pdf->Cell(300, 10, ''.$row['capacidad'].'', 0, 1, 'C');
			$pdf->SetY(72);
			$pdf->Cell(300, 10, ''.$row['cumplimiento'].'', 0, 1, 'C');
			$pdf->SetY(81);
			$pdf->Cell(300, 10, ''.$row['responsabilidad'].'', 0, 1, 'C');
			$pdf->SetY(90);
			$pdf->Cell(300, 10, ''.$row['capacidadIA'].'', 0, 1, 'C');
			$pdf->SetY(99);
			$pdf->Cell(300, 10, ''.$row['disposicion'].'', 0, 1, 'C');
			$pdf->SetY(108);
			$pdf->Cell(300, 10, ''.$row['liderazgo'].'', 0, 1, 'C');
			$pdf->SetY(117);
			$pdf->Cell(300, 10, ''.$row['resolucion'].'', 0, 1, 'C');
			$pdf->SetY(126);
			$pdf->Cell(300, 10, ''.$row['tomadecisiones'].'', 0, 1, 'C');
			$pdf->SetY(135);
			$pdf->Cell(300, 10, ''.$row['proactividad'].'', 0, 1, 'C');
			$pdf->SetY(153);
			$pdf->Cell(300, 10, ''.$row['planificacion'].'', 0, 1, 'C');
			$pdf->SetY(162);
			$pdf->Cell(300, 10, ''.$row['calidad'].'', 0, 1, 'C');
			$pdf->SetY(171);
			$pdf->Cell(300, 10, ''.$row['presentacion'].'', 0, 1, 'C');
			$pdf->SetY(180);
			$pdf->Cell(300, 10, ''.$row['participacion'].'', 0, 1, 'C');
			$pdf->SetY(189);
			$pdf->Cell(300, 10, ''.$row['aplicacion'].'', 0, 1, 'C');
			$pdf->SetY(198);
			$pdf->Cell(300, 10, ''.$row['creacion'].'', 0, 1, 'C');
			$pdf->SetY(207);
			$pdf->Cell(300, 10, ''.$row['actualizacion'].'', 0, 1, 'C');
			$pdf->SetY(228);
			$pdf->SetX(112);
			$pdf->multicell(98, 5, ''.$row['area_refuerzo'].'',0);

		}if($i == 2){
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte03_ssp.png',3,45,208);
			$pdf->ln(2);
			$pdf->SetY(47);
			$pdf->Cell(300, 10, ''.$row['calificacion_global'].'', 0, 1, 'C');
			$pdf->SetY(59);
			$pdf->Cell(300, 10, ''.$row['solicitar_practicante'].'', 0, 1, 'C');
			$pdf->SetY(71);
			$pdf->SetX(112);
			$pdf->multicell(98, 5, ''.$row['oportunidad_empleo'].'', 0);
			$pdf->SetY(106);
			$pdf->SetX(112);
			$pdf->multicell(98, 5, ''.$row['comentario_evaluacion'].'', 0);
			$pdf->SetY(162);
			$pdf->Cell(300, 10, ''.$row['lugar_fecha'].'', 0, 1, 'C');
			$pdf->SetY(172);
			$pdf->Cell(300, 10, ''.$row['nombre_representante'].'', 0, 1, 'C');
			$pdf->SetY(186);
			$pdf->Cell(300, 10, ''.$row['supervisor'].'', 0, 1, 'C');
		}
	}
}
	$pdf->Output();


?>