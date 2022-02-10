<?php
ob_start();
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');
// if(isset($_GET['alumno'])){
//     $alumno= $_GET['alumno'];
    // $sql="SELECT a.asignatura, a.codigo, a.uv FROM tbl_asignaturas a, tbl_asignaturas_aprobadas b 
    // WHERE b.id_persona=6 AND not exists (select * from tbl_asignaturas_aprobadas where a.Id_asignatura =b.Id_asignatura)";
    $sql="SELECT a.asignatura, a.codigo, a.uv FROM tbl_asignaturas a, tbl_asignaturas_aprobadas b 
    WHERE NOT EXISTS (SELECT a.asignatura, a.codigo, a.uv FROM tbl_asignaturas a, tbl_asignaturas_aprobadas b
     WHERE a.Id_asignatura= b.Id_asignatura AND b.id_persona = 6)";
    
    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
        echo json_encode($result);
    
ob_end_flush();
?>