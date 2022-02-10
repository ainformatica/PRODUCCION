<?php

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_TableGESTIONLAB.php');
$fecha = new DateTime(null, new DateTimeZone('America/Tegucigalpa'));
$hora = $fecha->format("H:i:s");

//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();

//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
//ENCABEZADO QUE DEBE IR IGUAL EN TODOS LOSREPORTES

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,6,'',0,0,'C');
$pdf->Cell(78,9,utf8_decode('UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS'),0,0,'C'); 
$pdf->Ln(5);
$pdf->Cell(60,6,'',0,0,'C');
$pdf->Cell(80,9,utf8_decode('FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES'),0,0,'C'); 
$pdf->Ln(5);
$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(120,9,utf8_decode('DEPARTAMENTO DE INFORMÁTICA'),0,0,'C'); 
// $pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1,6,'',0,0,'C');
$pdf->Ln(10);
$pdf->Cell(40,5,date('d/m/Y').' '.$hora,0,0,'C');
$pdf->Ln(10);
$pdf->Cell(45,6,'',0,0,'C');






$pdf->Cell(100,8,utf8_decode('REPORTE DE PRODUCTOS POR DESCARTAR'),1,0,'C'); 
$pdf->Ln(10);
//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra




// $pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1,6,'',0,0,'C');//mk
 

$pdf->Ln(7);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/gestion_lab_modelo.php";
$reportes = new reportes();
 
$rspta = $reportes->reportes_salida_degt();

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(26,26,25,70));


//Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(22,6,'NO. INV.',1,0,'C',1);
$pdf->Cell(70,6,'NOMBRE PRODUCTO',1,0,'C',1);
$pdf->Cell(24,6,'COSTO',1,0,'C',1);
$pdf->Cell(74,6,'ASIGNADO A',1,0,'C',1);
$pdf->Ln(10);

while($reg= $rspta->fetch_object())
{  
    
    // recibe producto,inventario
    $reportes_producto = $reg->producto;
    $reportes_inventario =$reg->inventario;
    $reportes_costo =$reg->costo;

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(22,15,$reportes_inventario,1,0,'L',0);
    $pdf->Cell(70,15,$reportes_producto,1,0,'L',1);
    $pdf->Cell(24,15,$reportes_costo,1,0,'L',0);
    $pdf->Cell(74,15,utf8_decode('DEPTO. INFORMÁTICA ADMINISTRATIVA'),1,0,'L',0);
    $pdf->Ln(15);

    // $pdf->SetFont('Arial','',10);
    // $pdf->Cell(30,6,'',0,0,'C');
    // // $pdf->Row(array(utf8_decode($reportes_inv),utf8_decode($reportes_nombre),utf8_decode($caracteristicas),utf8_decode($ubicacion)));
	// $pdf->Cell(30,6,utf8_decode('NO. INVENTARIO: '.utf8_decode($reportes_inventario)),0,0,'L'); 


    // $pdf->Ln(7);
    // $pdf->Cell(30,6,'',0,0,'C');
    // $pdf->Cell(30,6,utf8_decode('NOMBRE PRODUCTO: '.utf8_decode($reportes_producto)),0,0,'L'); 

    // $pdf->Ln(7);
    // $pdf->Cell(30,6,'',0,0,'C');
    // $pdf->Cell(30,4,utf8_decode('COSTO: '.utf8_decode('100 LPS')),0,0,'L'); 

    // $pdf->Ln(7);
    // $pdf->Cell(30,6,'',0,0,'C');
    // $pdf->Cell(30,4,utf8_decode('ASIGNADO A: '.utf8_decode('FACULTAD DE CIENCIAS ECONOMICAS,DEPARTAMENTO DE INFORMATICA ADMINSITRATIVA')),0,0,'L');    

}
ob_start();

session_start();




//Mostramos el documento pdf
$pdf->Output();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
// require_once('../clases/funcion_visualizar.php');
// require_once('../clases/funcion_permisos.php');


$Id_objeto = 12208;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Reporte', 'Genero el reporte para DEGT de productos por descartar ');

?>

