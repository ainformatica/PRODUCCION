<?php 
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexion.php');
require_once ('../Reporte/pdf/fpdf.php');


$año=$_POST['año'];
$introduccion=$_POST['introduccion'];
$objetivos=$_POST['objetivos'];
$conclu=$_POST['conclu'];
$reco=$_POST['reco'];

$sql = "SELECT IF( EXISTS( select fch_inicial_actividad from tbl_voae_actividades where YEAR(fch_inicial_actividad) = '$año'), 1, 0) as total";
                          $result = $mysqli->query($sql);
                          $valorcuenta = $result->fetch_array(MYSQLI_ASSOC);
                          $ultim = $valorcuenta['total'];

if ($ultim == 0) {
   echo '<script type="text/javascript">
                alert("NO SE PUEDE IMPRIMIR EL INFORME; NO HAY ACTIVIDADES REGISTRADAS ");
                window.location.href="../vistas/informe_final_cve_vista.php";
        </script>';

} else {

$instancia_conexion = new conexion();
//$mem = new memorandum();


class PDF_MC_Table extends FPDF
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
    
// variable to store widths and aligns of cells, and line height
var $widths;
var $aligns;
var $lineHeight;

//Set the array of column widths
function SetWidths($w){
    $this->widths=$w;
}

//Set the array of column alignments
function SetAligns($a){
    $this->aligns=$a;
}

//Set line height
function SetLineHeight($h){
    $this->lineHeight=$h;
}

//Calculate the height of the row
function Row($data)
{
    // number of line
    $nb=0;

    // loop each data to find out greatest line number in a row.
    for($i=0;$i<count($data);$i++){
        // NbLines will calculate how many lines needed to display text wrapped in specified width.
        // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    }
    
    //multiply number of line with line height. This will be the height of current row
    $h=$this->lineHeight * $nb;

    //Issue a page break first if needed
    $this->CheckPageBreak($h);

    //Draw the cells of current row
    for($i=0;$i<count($data);$i++)
    {
        // width of the current col
        $w=$this->widths[$i];
        // alignment of the current col. if unset, make it left.
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //calculate the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
 
    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }
 
    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }
 
    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
 
    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
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
    function portada()
    {  
        $this->SetFont('Arial','B',28);
        $this->SetTextColor(0,0,0);
        $this->setY(90);
        $this->setX(38);
        $this->multicell(150,10, utf8_decode('INFORME DE ACTIVIDADES' ), 0,'C',0);
        $this->ln();
        $año=$_POST['año'];
        $this->setX(13);
        $this->multicell(200,10, utf8_decode('REALIZADAS DEL AÑO '.$año=$_POST['año']), 0,'C',0);
        //$this->write(5,'INFORME DE ACTIVIDAD');

        $this->ln();
        $this->Image('../dist/img/lucemaspicio.jpg', 130, 150, 100,120);
    }

   


    function CuerpodelReporte()
    {  
       
        
        $this->SetFont('Arial','',10);
        
        //Table with 20 rows and 4 columns
        $this -> SetFont( 'Arial' , '' , 10 ); 
        
        $this -> SetWidths( Array ( 20 , 17, 20 , 50 , 20,35,35 )); 
        $this -> SetLineHeight( 7 ); 
        $this -> SetAligns ( Array ( 'L' , 'L' , 'L' , 'L' ));

        //agregue el encabezado de la tabla usando celdas estándar 
//establezca la fuente en negrita 
        $this -> SetFont ( 'Arial' , 'B' , 10 ); 
        $this->setY(60);
        $this->setX(60);
        $this->write(5,utf8_decode('LISTADO ACTIVIDADES FINALIZADAS DEL AÑO '.$año=$_POST['año']));
        $this->ln();
        $this->setY(70);
        $this->SetFillColor(45, 65, 84);
        $this->SetTextColor(255,255,255);
        $this -> Cell ( 20 , 7 , "NOMBRE" , 1, 0, 'C', true);
        $this -> Cell ( 17 , 7 , "PERIODO" , 1, 0, 'C', true);  
        $this -> Cell ( 20 , 7 , "AMBITO" , 1, 0, 'C',true); 
        $this -> Cell ( 50 , 7 , "DESCRIPCION" , 1, 0, 'C',true); 
        $this -> Cell ( 20 , 7 , "FECHA" , 1, 0, 'C',true); 
        $this -> Cell ( 35 , 7 , "OBSERVACIONES" , 1, 0, 'C',true);
        $this -> Cell ( 35 , 7 , "ORGANIZADORES" , 1, 0, 'C',true);  
        $this -> Ln (); 
        $this -> SetFont ('Arial' , '' , 10 );
        global $instancia_conexion;

        $sql="SELECT tbl_voae_actividades.id_actividad_voae, tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.descripcion, tbl_voae_actividades.fch_inicial_actividad, tbl_voae_actividades.staff_alumnos, tbl_voae_actividades.observaciones, tbl_voae_actividades.periodo, tbl_voae_ambitos.nombre_ambito FROM tbl_voae_actividades join tbl_voae_ambitos on tbl_voae_actividades.id_ambito=tbl_voae_ambitos.id_ambito Where id_estado = 6 and tipo_actividad = 'ACTIVIDAD INTERNA' Order By tbl_voae_actividades.periodo";

        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        
        while ($reg = $stmt->fetch_object()) {
        for($i=0;$i<1;$i++)
            $this->SetTextColor(0,0,0);
            $this->Row(array(utf8_decode($reg->nombre_actividad),utf8_decode($reg->periodo),utf8_decode($reg->nombre_ambito),utf8_decode($reg->descripcion),utf8_decode($reg->fch_inicial_actividad),utf8_decode($reg->observaciones),utf8_decode($reg->staff_alumnos)));
        
        }
    }

    function Introduccion()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->setY(60);
        $this->setX(92);
        $this->write(5,'INTRODUCCION');
        
        $introduccion=$_POST['introduccion'];
        $objetivos=$_POST['objetivos'];
        $conclu=$_POST['conclu'];
        $reco=$_POST['reco'];
        $año=$_POST['año'];
        $this->SetFont('Arial','',10);
        $this->setY(80);
            $this->setX(35);
        $this->MultiCell(150,10,utf8_decode($introduccion),0,'J',0);

    }

    function Objetivos()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->setY(60);
        $this->setX(92);
        $this->write(5,'OBJETIVOS');
       
        $objetivos=$_POST['objetivos'];
        
        $this->SetFont('Arial','',10);
        $this->setY(70);
        $this->setX(35);
        $this->Multicell(150,10,utf8_decode($objetivos),0,'J',0);

    }

    function Conclusiones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->setY(60);
        $this->setX(92);
        $this->write(5,'CONCLUSIONES');
        
        $conclu=$_POST['conclu'];
    
        
        $this->SetFont('Arial','',10);
        $this->setY(70);
        $this->setX(35);
        $this->Multicell(150,10,utf8_decode($conclu),0,'J',0);

    }
    function Recomendaciones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
        $this->setY(60);
        $this->setX(92);
        $this->write(5,'RECOMENDACIONES');
    
        $reco=$_POST['reco'];
       
        
        $this->SetFont('Arial','',10);
        $this->setY(70);
        $this->setX(35);
        $this->Multicell(150,10,utf8_decode($reco),0,'J',0);

    }



    function footer()
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


    
    //***** Aquí comienza código para ajustar texto *************

    //***********************************************************

    
}
$fpdf = new PDF_MC_Table('P', 'mm', 'letter', true);
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->portada();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Introduccion();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Objetivos();
$fpdf->AddPage('portraid', 'Letter',0);

$fpdf->CuerpodelReporte();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Conclusiones();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Recomendaciones();
$fpdf->AliasNbPages();


$fpdf->output();
}

?>
<script src="../plugins/select2/js/select2.min.js"></script>