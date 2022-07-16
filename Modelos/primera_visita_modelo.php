<?php
require "../clases/conexion_mantenimientos.php";
session_start();
$instancia_conexion = new conexion();

class primera_visita
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de primera unica de supervision
	public function insertar($numero_cuenta,$funciones,$funciones_diseno,$funciones_redes,$funciones_capacitacion,$funciones_seguridad
    ,$funciones_auditoria,$funciones_base,$funciones_soporte,$funciones_programacion,$otros,$comunicacion
    ,$puntualidad,$responsabilidad,$creatividad,$presentacion,$atencion,$colaborativo,$trabajo_equipo
    ,$proactivo,$relaciones,$analisis,$diseno,$programador,$mantenimiento,$comentario
    ,$calificacion,$solicitar,$representante,$lugar,$fecha,$aspecto_a,$aspecto_s)
	{ 
        $visita="Primera Supervisión";
        global $instancia_conexion;
        $sql = "call ins_primera_visita('$numero_cuenta',
                                        '$comentario',
                                        '$representante',
                                        '$solicitar',
                                        '$lugar',
                                        '$visita',
                                        '$funciones',
                                        '$funciones_diseno',
                                        '$funciones_redes',
                                        '$funciones_capacitacion',
                                        '$funciones_seguridad',
                                        '$funciones_auditoria',
                                        '$funciones_base',
                                        '$funciones_soporte',
                                        '$funciones_programacion',
                                        '$otros',
                                        '$comunicacion',
                                        '$puntualidad',
                                        '$responsabilidad',
                                        '$creatividad',
                                        '$presentacion',
                                        '$atencion',
                                        '$colaborativo',
                                        '$trabajo_equipo',
                                        '$proactivo',
                                        '$relaciones',
                                        '$analisis',
                                        '$diseno',
                                        '$programador',
                                        '$mantenimiento',
                                        '$aspecto_a'
                                        '',
                                        '$aspecto_s')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

    public function selectCurso(){
      global $instancia_conexion ;
      $id_persona1=$_SESSION['id_persona'];
      $sql="SELECT concat(p.nombres,' ',p.apellidos) as nombres, vap.id_persona 
      FROM tbl_vinculacion_aprobacion_practica vap, tbl_personas p, tbl_practica_estudiantes pe
      
      WHERE p.id_persona=vap.id_persona AND vap.id_estado_vinculacion=1 AND vap.id_horas=800 AND pe.docente_supervisor=$id_sup;";
      
        return $instancia_conexion->ejecutarConsulta($sql);

    }


    public function rellenarDatos($id_persona){
        global $instancia_conexion ;
        $sql="SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombres, a.identidad, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, m.modalidad, dp.descripcion AS horario, concat(vap.horario_entrada,' a ',vap.horario_salida) as horas, c.valor Correo, e.valor Celular, ep.jefe_inmediato, na.descripcion as nivel_a, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.celular_jefe_inmediato, a.id_persona

        FROM

        tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        JOIN tbl_vinculacion_aprobacion_practica AS  vap ON vap.id_persona = a.id_persona
        JOIN tbl_nivel_academico AS na ON na.id_nivel_a = ep.id_nivel_a
        JOIN tbl_modalidad AS m ON m.id_modalidad = pe.id_modalidad
        JOIN tbl_dias_practica AS dp ON dp.id_dias = vap.id_dias
        JOIN tbl_personas_extendidas AS px on px.id_atributo=12 and px.id_persona=a.id_persona and pe.id_persona='$id_persona';";
          return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
  
      }

    

}

























?>


