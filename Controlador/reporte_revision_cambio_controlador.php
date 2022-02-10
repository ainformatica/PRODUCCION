<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');

$instancia_conexion = new conexion();


class myPDF extends FPDF
{
    public $titulo;
    public $sub_titulo;
    public $sql;
public function __construct($titulo='undefine', $sql='undefine'){
    parent::__construct();
    $this ->titulo =$titulo;
    $this -> sql =$sql;
}
    function header()
    {
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s');

        $this->Image('../dist/img/logo_ia.jpg', 30, 10, 35);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(330, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(325, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA "), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(330, 10, utf8_decode("SOLICITUD DE CAMBIO DE CARRERA"), 0, 0, 'C');
        $this->ln(17);
        $this->SetFont('Arial', '', 12);
        $this->Cell(60, 10, utf8_decode(""), 0, 0, 'C');
        $this->Cell(420, 10, "FECHA: " . $fecha, 0, 0, 'C');
        $this->ln();
    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    
    function view()
    {   

        global $instancia_conexion;
        $sql ="SELECT p.nombres, p.apellidos, s.tipo, s.Id_cambio, s.correo, x.valor, s.aprobado, s.observacion,s.fecha_creacion, c.centro_regional, f.nombre 
        FROM tbl_cambio_carrera s, tbl_personas p, tbl_facultades f ,tbl_personas_extendidas x, tbl_centros_regionales c 
        WHERE s.Id_cambio=(SELECT MAX(Id_cambio) FROM tbl_cambio_carrera) AND p.id_persona=s.id_persona 
        and s.Id_centro_regional = c.Id_centro_regional and p.id_persona= x.id_persona and s.Id_facultad=f.Id_facultad";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->SetXY(25, 60);
            $this->Cell(30, 8, 'SOLICITUD N.:', 0, 'L');
            $this->Cell(20, 8, $reg['Id_cambio'], 120, 85.5);

            $this->SetXY(25, 70);
            $this->Cell(30, 8, 'NOMBRE:', 0, 'L');
            $this->Cell(20, 8, $reg['nombres'].$reg['apellidos'], 120, 85.5);

$this->SetXY(25, 80);
$this->Cell(30, 8, 'CUENTA:', 0, 'L');
$this->Cell(20, 8,$reg['valor'], 120, 85.5);
//*****
$this->SetXY(25,90);
$this->Cell(30, 8, 'TIPO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['tipo']), 120, 85.5);

$this->SetXY(25,100);
$this->Cell(30, 8, 'CENTRO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['centro_regional']), 120, 85.5);

$this->SetXY(25,110);
$this->Cell(30, 8, 'FACULTAD:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['nombre']), 120, 85.5);
//*****
$this->SetXY(25, 120);
$this->Cell(30, 8, 'CORREO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['correo']), 120, 85.5);
//****
$this->SetXY(25, 130);
$this->Cell(35, 8, 'OBSERVACION:', 0, 'L');
$this->Cell(20, 8, $reg['observacion'], 120, 85.5);

$this->SetXY(25, 140);
$this->Cell(30, 8, 'ESTADO:', 0, 'L');
$this->Cell(20, 8,$reg['aprobado'], 120, 85.5);

$this->SetXY(25, 150);
$this->Cell(30, 8, 'FECHA:', 0, 'L');
$this->Cell(20, 8, $reg['fecha_creacion'], 120, 85.5);
           
           
        }
    }
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->view();
$pdf->SetFont('Arial', '', 15);
$pdf->settitle('SOLICITUD_CAMBIO_CARRERA.PDF');


$pdf->Output();
ob_end_flush();
?>