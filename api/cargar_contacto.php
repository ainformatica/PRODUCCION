<?php
ob_start();
session_start();


require_once ('../clases/Conexion.php');
$idestudiente=$_POST['contacto'];
$consulta_contacto="SELECT id,nombre FROM tbl_contacto_practica where persona_id=$idestudiente";

$resultset = $mysqli->query($consulta_contacto);
$response=mysqli_fetch_all($resultset);
echo json_encode($response);
//$dataempresa= mysqli_fetch_assoc($respuesta)