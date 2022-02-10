<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');

if (isset($_POST)) {
    if($_POST['funcion']=='enviarINFO'){
     enviarDatos();
    }    
}

function enviarDatos(){
    global $mysqli;
    $id_chat= isset($_POST['id_chat']) ? $_POST['id_chat'] : '';; 
    $message= isset($_POST['message']) ? $_POST['message'] : '';;
    
    $sql = "INSERT INTO `tbl_movil_mensajes_chat` VALUES (NULL, $id_chat, 1, '$message', 0, 1, sysdate())";
    $resultado = $mysqli->query($sql);
    if($resultado == true){
        return 'enviado';
    }else{
        return 'no enviado';
    }
}

ob_end_flush();
?>