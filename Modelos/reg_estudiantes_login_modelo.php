<?php
require_once "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class modelo_reg_estudiantes2
{
   public function traerId_estudiante($usuario){
        global $instancia_conexion;
        $sql = 'select id_persona from tbl_usuarios where Usuario="'.$usuario.'";';
        return $instancia_conexion->ejecutarConsulta($sql);
    }

    
    //Insertar registros
    public function completar_registro($id_persona2,$identidad,$nacionalidad,$ecivil,$fecha_nacimiento,$lugar_nacimiento,
    $trabajo, $egresado,$carrera,$cregional, $telefono){
        global $instancia_conexion;
        
        $sql="call proc_update_insert_registro_estudiantes ('$id_persona2', '$identidad', '$nacionalidad', '$ecivil', '$fecha_nacimiento', '$lugar_nacimiento', '$trabajo', '$egresado','$carrera', '$cregional','$telefono')";
        return $instancia_conexion->ejecutarConsulta($sql);

    }
    
    public function Registrar_foto($id_persona2, $nombrearchivo){
        global $instancia_conexion;
        $sql="CALL proc_insert_completar_foto('$id_persona2', '$nombrearchivo')";        
        return $instancia_conexion->ejecutarConsulta($sql);
    }

    public function Registrar_curriculum($id_persona2, $nombrearchivo2){
        global $instancia_conexion;
        $sql="CALL proc_insert_completar_curriculum('$id_persona2','$nombrearchivo2')";        
        return $instancia_conexion->ejecutarConsulta($sql);
    }

    function ExisteIdentidad($identidad){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS(SELECT  identidad FROM tbl_personas WHERE identidad='$identidad') as existe");      
        return $consulta;
    }
    
    function validar_depto($codigo)
    {
        global $instancia_conexion;
        $sql4 = "call proc_existe_municipio_depto($codigo)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }
   


}
