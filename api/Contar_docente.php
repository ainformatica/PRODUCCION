<?php
session_start();
ob_start();
header("Content-Type:application/json");

require_once('../clases/funcion_bitacora.php');
require_once('../clases/Conexion.php');


if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query1="SELECT count(*) CANTIDAD FROM tbl_practica_estudiantes where docente_supervisor=$id"; 
    $resultado=$mysqli->query($query1);
$estudiantes=mysqli_fetch_assoc($resultado);

    echo json_encode($estudiantes);
}