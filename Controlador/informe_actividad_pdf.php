<?php


require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexion.php');
require_once ('../Reporte/pdf/fpdf.php');
//require_once ('../pdf/fpdf/fpdf.php');


$instancia_conexion = new conexion();
//$mem = new memorandum();


class mypdf extends FPDF
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
    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
    $k=$this->k;
    if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
    {
        $x=$this->x;
        $ws=$this->ws;
        if($ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        $this->AddPage($this->CurOrientation);
        $this->x=$x;
        if($ws>0)
        {
            $this->ws=$ws;
            $this->_out(sprintf('%.3F Tw',$ws*$k));
        }
    }
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $s='';
    if($fill || $border==1)
    {
        if($fill)
            $op=($border==1) ? 'B' : 'f';
        else
            $op='S';
        $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
    }
    if(is_string($border))
    {
        $x=$this->x;
        $y=$this->y;
        if(is_int(strpos($border,'L')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
        if(is_int(strpos($border,'T')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
        if(is_int(strpos($border,'R')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        if(is_int(strpos($border,'B')))
            $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
    }
    if($txt!='')
    {
        if($align=='R')
            $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
        elseif($align=='C')
            $dx=($w-$this->GetStringWidth($txt))/2;
        elseif($align=='FJ')
        {
            //Set word spacing
            $wmax=($w-2*$this->cMargin);
            $nb=substr_count($txt,' ');
            if($nb>0)
                $this->ws=($wmax-$this->GetStringWidth($txt))/$nb;
            else
                $this->ws=0;
            $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
            $dx=$this->cMargin;
        }
        else
            $dx=$this->cMargin;
        $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
        if($this->ColorFlag)
            $s.='q '.$this->TextColor.' ';
        $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
        if($this->underline)
            $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
        if($this->ColorFlag)
            $s.=' Q';
        if($link)
        {
            if($align=='FJ')
                $wlink=$wmax;
            else
                $wlink=$this->GetStringWidth($txt);
            $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$wlink,$this->FontSize,$link);
        }
    }
    if($s)
        $this->_out($s);
    if($align=='FJ')
    {
        //Remove word spacing
        $this->_out('0 Tw');
        $this->ws=0;
    }
    $this->lasth=$h;
    if($ln>0)
    {
        $this->y+=$h;
        if($ln==1)
            $this->x=$this->lMargin;
    }
    else
        $this->x+=$w;
    }
    public function portada()
    {  
        $this->SetFont('Arial','B',28);

        $this->setY(90);
        $this->setX(38);
        $this->multicell(150,10, utf8_decode('INFORME DE ACTIVIDAD' ), 0,'C',0);
        //$this->write(5,'INFORME DE ACTIVIDAD');

        $this->ln();
        $id_actividad1 = $_POST["id_actividad_voae"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, 
        conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, 
        id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_actividad= '$id_actividad1'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(125);
            $this->setX(35);
            $this->SetFont('Arial','',25);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->nombre_actividad), 0,'C',0);
            $this->ln();
            $this->setY(135);
            $this->setX(33.5);
            $this->multicell(150,10, utf8_decode('('.$reg->fch_informe.')'), 0,'C',0);
           
            //$this->write(7,  $reg->nombre_actividad);
            $this->ln();
            $this->Image('../dist/img/lucemaspicio.jpg', 130, 150, 100,120);
        

        }

    }

    

    public function introduccion()
    {  
        $this->SetFont('Arial','B',10);

        $this->setY(60);
        $this->setX(90);
        $this->write(5,'INTRODUCCION');

        $this->ln();
        $id_actividad1 = $_POST["id_actividad_voae"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_actividad= '$id_actividad1'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->introduccion), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    }

    public function objetivos()
    {  
        $this->SetFont('Arial','B',10);

        $this->setY(60);
        $this->setX(90);
        $this->write(5,'OBJETIVOS'); 

        $this->ln();
        $id_actividad1 = $_POST["id_actividad_voae"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_actividad= '$id_actividad1'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->objetivos), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    } 
    public function desarrollo()
    {  
        $this->SetFont('Arial','B',10);
 
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'DESARROLLO DE LA ACTIVIDAD'); 

        $this->ln();
        $id_actividad1 = $_POST["id_actividad_voae"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_actividad= '$id_actividad1'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->desarrollo), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    }
    
       
    public function cuerpo()
{
    
    $this->SetFont('Arial','B',15);

        $this->setY(60);
        $this->setX(65);
        $this->write(5,'LISTADO ASISTENCIA ACTIVIDAD'); 

        $this->SetFont('Arial','B',10);
        $this->SetFillColor(45, 65, 84);
        $this->SetTextColor(255,255,255);
        $this->SetY(70);
        $this->SetX(5);
        $this->Cell(30, 7, "CUENTA", 1, 0, 'C',1,'F');
        $this->Cell(80, 7, "NOMBRE COMPLETO", 1, 0, 'C',1,'F');
        $this->Cell(20, 7, "HORAS", 1, 0, 'C',1,'F');
        $this->Cell(76, 7, "CARRERA", 1, 0, 'C',1,'F');
        $this->ln();
 

    global $instancia_conexion;
    $id_actividad1 = $_POST["id_actividad_voae"];
      

    $sql="SELECT * FROM tbl_voae_asistencias WHERE id_actividad_voae = '$id_actividad1'";


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

public function conclusiones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'CONCLUSIONES'); 

        $this->ln();
        $id_actividad1 = $_POST["id_actividad_voae"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_actividad= '$id_actividad1'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->conclusiones), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);

            $this->ln();
        

        }

    }

    public function footer()
    {
        //Texto footer
        $this->SetFillColor(15,57,117);
        $this->rect(0,270,120,10,'F');
        //$this->SetFont('Arial','B',10);
        //$this->SetTextColor(0,0,0);
        //$this->cell(0,236, utf8_decode('Tegucigalpa Ciudad Universitaria '),0,1,'L');

        // Texto de orden de pagina
        $this->SetFillColor(255, 204, 15);
        $this->rect(120,270,120,10,'F');
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(270);
        $this->setX(210);
        $this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,1,'C');

    }
}


$fpdf = new mypdf('P', 'mm', 'letter', true);
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->portada();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->introduccion();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->objetivos();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->desarrollo();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->cuerpo();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->conclusiones();
$fpdf->AliasNbPages();
$fpdf->SetMargins(20,30,30,20);
$fpdf->output();
