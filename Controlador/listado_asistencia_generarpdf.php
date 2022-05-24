<?php

session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexion.php');
require_once ('../Reporte/pdf/fpdf.php');

$instancia_conexion = new conexion();
//$mem = new memorandum();

class pdf extends FPDF
{


 public function header()
    {
        $this->SetFillColor(15,57,117);
        $this->rect(0,0,220,40,'F');
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->setY(13);
        $this->Image('../dist/img/kkk.png', 180, 10,25,25);

        $this->setX(200);
        $this->setY(13);
        $this->Image('../dist/img/logo_unah2.png', 8, 10, 16);

        $this->setX(35);
        $this->write(5,'UNIVERSIDAD NACIONAL AUTONOMA DE HONDURAS');
        $this->ln();
        $this->setX(35);
        $this->write(5,'FACULTAD DE CIENCIAS ECONOMICAS, ADMINISTRAIVAS Y CONTABLES');
        $this->ln();
        $this->setX(35);
        $this->write(5,'DEPARTAMENTO DE INFORMATICA');
        $this->ln();
        $this->setX(35);
        $this->write(5,'COMITE DE VIDA ESTUDIANTIL');
        $this->ln();
        $this->SetX(35);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(255,255,255);
        $this->write(5,'Fecha de documento:');
        $this->SetTextColor(255,255,255);
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('d-m-Y H:i');
        $this->write(5,'    '.$fecha);
        $this->Ln(12);



    }

 public function cuerpo()
{
       
    
   $id_actividad = $_SESSION['id_actividad_cve'];
   $this->SetFont('Arial','B',15);

        $this->setY(50);
        $this->setX(65);
        $this->write(5,'LISTADO DE ASISTENCIA');
        $this->setX(25);
        $this->setY(65);
        $this->ln();
        $this->write(5,'Lugar: '); 
        $this->setX(25);
        $this->setY(60);
        $this->write(5,'Nombre Actividad: ');
        $this->setX(25);
        $this->setY(71);
        $this->ln();
        $this->write(5,'Fecha: ');
        $this->setX(25);
        $this->setY(65);
        $this->write(5,utf8_decode('Ámbito: '));
        $this->ln();

        global $instancia_conexion;
        $id_actividad = $_SESSION['id_actividad_cve'];
        $sql2="select tbl_voae_actividades.id_actividad_voae, tbl_voae_actividades.ubicacion, tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.fch_inicial_actividad, tbl_voae_actividades.id_ambito, tbl_voae_ambitos.nombre_ambito, tbl_voae_ambitos.id_ambito from tbl_voae_actividades JOIN tbl_voae_ambitos on tbl_voae_actividades.id_ambito = tbl_voae_ambitos.id_ambito where id_actividad_voae = '$id_actividad'";
        $stmt2 = $instancia_conexion->ejecutarConsulta($sql2);

         while ($reg = $stmt2->fetch_object()) {

         $this->ln();
        $this->setY(60);
        $this->SetX(59);
        $this->SetFont('Arial','B');
        $this->write(5,utf8_decode($reg->nombre_actividad));
        $this->setY(65);
        $this->SetX(32);
        $this->SetFont('Arial','B');
        $this->write(5, utf8_decode($reg->nombre_ambito));
        $this->setY(70);
        $this->SetX(29);
        $this->SetFont('Arial','B');
        $this->write(5, utf8_decode($reg->ubicacion));
        $this->setY(76);
        $this->SetX(29);
        $this->SetFont('Arial','B');
        $this->write(5, utf8_decode($reg->fch_inicial_actividad));
        }


        $this->SetFont('Arial','B',10);
        $this->SetFillColor(45, 65, 84);
        $this->SetTextColor(255,255,255);
        $this->SetY(87);
        $this->SetX(5);
        $this->Cell(30, 7, "CUENTA", 1, 0, 'C',1,'F');
        $this->Cell(80, 7, "NOMBRE COMPLETO", 1, 0, 'C',1,'F');
        $this->Cell(20, 7, "HORAS", 1, 0, 'C',1,'F');
        $this->Cell(76, 7, "CARRERA", 1, 0, 'C',1,'F');
        $this->ln();
 

    global $instancia_conexion;
     $id_actividad = $_SESSION['id_actividad_cve'];
      

    $sql="SELECT * FROM tbl_voae_asistencias WHERE id_actividad_voae = '$id_actividad'";


    $stmt = $instancia_conexion->ejecutarConsulta($sql);
   

        while ($reg = $stmt->fetch_object()) {
            $this->SetFont('Arial','',7);
            $this->SetTextColor(0,0,0);
            $this->SetX(5);

            $this->Cell(30, 7, $reg->cuenta, 1, 0, 'C');
            $this->Cell(80, 7, utf8_decode($reg->nombre_alumno), 1, 0, 'C');
            $this->Cell(20, 7, $reg->cant_horas, 1, 0, 'C');
            $this->Cell(76, 7, utf8_decode($reg->carrera), 1, 0, 'C');
            $this->ln();
        }
}


 


 public function footer()
{
$this->SetFillColor(15,57,117);
$this->rect(0,270,120,10,'F');

 $this->SetFillColor(255, 204, 15);
$this->rect(120,270,120,10,'F');
$this->SetFont('Arial','B',10);
$this->SetTextColor(255,255,255);
$this->setY(270);
$this->setX(210);
$this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,1,'C');

 }
}

$fpdf = new pdf('P', 'mm', 'legal', true);
$fpdf->AddPage('portraid', 'Letter',0);
//$fpdf->setY(60);

$fpdf->cuerpo();
$fpdf->AliasNbPages();
$fpdf->SetMargins(20,30,30,20);
$fpdf->output();