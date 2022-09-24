<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');


if (isset($_POST['id_persona']) ) {
    $id_persona=$_POST['id_persona'];




$sql = "select cp.clases_aprobadas, cp.porcentaje_clases ,concat(p.nombres,' ',p.apellidos) as estudiante, px.valor as cuenta
from tbl_charla_practica cp, tbl_personas p, tbl_personas_extendidas px where px.id_atributo=12 and px.id_persona=p.id_persona and p.id_persona=cp.id_persona and cp.id_persona=$id_persona ";





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
        $this->Image('../dist/img/encabezado_clase.png',10,12,195);
        // Título
		$this->SetY(17);
        $this->SetX(165);
        $this->Write(15,utf8_decode('15/10/2021'));
		$this->SetY(21);
        $this->SetX(185);
        $this->Write(15,utf8_decode('01'));
        $this->SetY(31);
        $this->SetX(175);
        $this->Write(15,utf8_decode('25/10/2021'));

        $this->Ln(20);
    }
} 
//date_default_timezone_get('America/Tegucigalpa');

function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $numeroDia." de ".$nombreMes." de ".$anio;
}

$fecha=date("Y-m-d H:i:s");

	$row= mysqli_fetch_assoc($mysqli->query($sql));


	$pdf = new PDF('P','mm','letter',true);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Image('../dist/img/fondo.png',1,70,216);
	

	$pdf->Cell(0,5,utf8_decode('CONSTANCIA '),0,1,'C');
	$pdf->ln(5);
	$pdf->ln(5);



	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);

	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('La Suscrita Coordinadora de la Carrera de Informática Administrativa de la UNAH, por este medio hace constar que el estudiante '.$row['estudiante'].' con número de cuenta '.$row['cuenta'].' ha aprobado un total de '.$row['clases_aprobadas'].' asignaturas  lo  cual  totaliza  un  '.$row['porcentaje_clases'].'%  del Plan de Estudios de la Licenciatura en Informática. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Y  para   efectos   de   realizar   su   Práctica   Profesional   Supervisada   firmo   la presente en la Ciudad Universitaria "José Trinidad Reyes" el '.fechaCastellano($fecha).'. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);



    $pdf->ln(32);
	$pdf->SetFont('Times','BI',14);
	$pdf->ln(8);
	$pdf->cell(0,6,utf8_decode('Dulce Monserrat Del Cid Fiallos'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Times','I',14);
	$pdf->cell(0,6,utf8_decode('Coordinación Académica'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');


	$pdf->Output();
}

$carpeta='../Documentacion_practica/'.$row['cuenta'].'/';
if(!file_exists($carpeta)){
  mkdir($carpeta,0777,true);

}

  $pdf = new PDF('P','mm','letter',true);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->Image('../dist/img/fondo.png',1,70,216);
	

	$pdf->Cell(0,5,utf8_decode('CONSTANCIA '),0,1,'C');
	$pdf->ln(5);
	$pdf->ln(5);



	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);

	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('La Suscrita Coordinadora de la Carrera de Informática Administrativa de la UNAH, por este medio hace constar que el estudiante '.$row['estudiante'].' con número de cuenta '.$row['cuenta'].' ha aprobado un total de '.$row['clases_aprobadas'].' asignaturas  lo  cual  totaliza  un  '.$row['porcentaje_clases'].'%  del Plan de Estudios de la Licenciatura en Informática. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Y  para   efectos   de   realizar   su   Práctica   Profesional   Supervisada   firmo   la presente en la Ciudad Universitaria "José Trinidad Reyes" el '.fechaCastellano($fecha).'. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);



    $pdf->ln(32);
	$pdf->SetFont('Times','BI',14);
	$pdf->ln(8);
	$pdf->cell(0,6,utf8_decode('Dulce Monserrat Del Cid Fiallos'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Times','I',14);
	$pdf->cell(0,6,utf8_decode('Coordinación Académica'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');


	$pdf->Output('F','../Documentacion_practica/'.$row['cuenta'].'/04_CONSTANCIA_CLASES_APROBADAS.pdf');

?>