<?php
ob_start();
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');

if(isset($_GET['alumno'])){
    $alumno= $_GET['alumno'];
    $sql="SELECT tbl_personas_extendidas.valor, tbl_personas.nombres, tbl_facultades.nombre, tbl_personas.apellidos, tbl_centros_regionales.centro_regional, tbl_cambio_carrera.correo, tbl_cambio_carrera.tipo, tbl_cambio_carrera.aprobado, 
    tbl_cambio_carrera.razon_cambio,observacion, tbl_cambio_carrera.Id_cambio, tbl_personas.id_persona, 
    tbl_facultades.Id_facultad, tbl_centros_regionales.Id_centro_regional FROM tbl_cambio_carrera 
    INNER JOIN tbl_personas ON tbl_cambio_carrera.id_persona=tbl_personas.id_persona 
    INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona 
    INNER JOIN tbl_facultades ON tbl_cambio_carrera.Id_facultad=tbl_facultades.Id_facultad 
    INNER JOIN tbl_centros_regionales ON tbl_cambio_carrera.Id_centro_regional = tbl_centros_regionales.Id_centro_regional
     WHERE tbl_cambio_carrera.Id_cambio= '$alumno' and tbl_cambio_carrera.tipo = 'interno'";

    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}elseif(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];

    $consulta="SELECT tbl_personas.id_persona, observacion, aprobado,tbl_personas.nombres, tbl_facultades.Id_facultad, 
    tbl_facultades.nombre, tbl_centros_regionales.Id_centro_regional, tbl_centros_regionales.centro_regional, tbl_personas.apellidos, 
    tbl_personas_extendidas.valor, tbl_cambio_carrera.fecha_creacion, documento, tipo, tbl_cambio_carrera.Id_cambio, correo 
    from tbl_cambio_carrera inner join tbl_personas on tbl_cambio_carrera.id_persona = tbl_personas.id_persona 
    inner join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona 
    iNNER JOIN tbl_facultades ON tbl_cambio_carrera.Id_facultad=tbl_facultades.Id_facultad 
    INNER JOIN tbl_centros_regionales ON tbl_cambio_carrera.Id_centro_regional=tbl_centros_regionales.Id_centro_regional 
    where tipo = 'interno'";  

    if ($R = $mysqli->query($consulta)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}
else{

    $sql="SELECT tbl_personas.nombres,tbl_personas.apellidos,tbl_personas_extendidas.valor, correo, aprobado, observacion,
    tbl_cambio_carrera.Id_cambio,tipo,Fecha_creacion FROM tbl_cambio_carrera INNER JOIN tbl_personas
     ON tbl_cambio_carrera.id_persona= tbl_personas.id_persona INNER JOIN tbl_personas_extendidas 
     ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona where tbl_cambio_carrera.tipo = 'interno'";
    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}

ob_end_flush();
?>