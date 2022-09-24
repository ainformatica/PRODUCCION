<?php
require "../clases/conexion_mantenimientos.php";
session_start();


$instancia_conexion = new conexion();

class segunda_visita
{
    	//Implementamos nuestro constructor
	public function __construct()
	{

    }
    
	//Implementamos un método para insertar registros de una visita unica de supervision
	public function insertar($numero_cuenta, $adaptacion, $lenguaje, $capacidad, $cumplimiento, $responsabilidad, $capacidadIA, $disposicion, $liderazgo, $resolucion, $tomadesiciones, $proactividad, $planificacion, $calidad,
	$presentacion, $participacion, $aplicacion, $creacion, $actualizacion, $comentario, $area_refuerzo, $calificacion, $solicitar, $representante, $supervisor, $lugar, $oportunidad, $id_persona)
	{
		$visita="Segunda Supervisión";
        global $instancia_conexion;
		$sql = "call ins_segunda_visita('$numero_cuenta',
									  '$comentario',
									  '$area_refuerzo',
									  '$calificacion',
									  '$solicitar',
									  '$oportunidad',
									  '$representante',
									  '$supervisor',
									  '$lugar',
									  '$visita',
									  '$adaptacion',
									  '$lenguaje',
									  '$capacidad',
									  '$cumplimiento',
									  '$responsabilidad',
									  '$capacidadIA',
									  '$disposicion',
									  '$liderazgo',
									  '$resolucion',
									  '$tomadesiciones',
									  '$proactividad',
									  '$planificacion',
									  '$calidad',
									  '$presentacion',
									  '$participacion',
									  '$aplicacion',
									  '$creacion',
									  '$actualizacion')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	public function selectCurso(){
		global $instancia_conexion ;
		$id_persona1=$_SESSION['id_persona'];
		$id_supervisor=$_SESSION['id_supervisor'];
      $sql="SELECT DISTINCT concat(p.nombres,' ',p.apellidos) as nombres, vap.id_persona 
      FROM tbl_vinculacion_aprobacion_practica vap, tbl_personas p, tbl_evaluaciones_practica evp, tbl_practica_estudiantes pe
      
      WHERE p.id_persona=vap.id_persona AND p.id_persona=evp.id_persona AND vap.id_estado_vinculacion=1 AND pe.docente_supervisor=$id_supervisor AND vap.id_horas=800 AND evp.numero_visita='Primera Supervisión' AND pe.segunda_supervision=0 AND pe.primera_supervision=1;";
		  return $instancia_conexion->ejecutarConsulta($sql);
  
	  }
  
  
	  public function rellenarDatos($id_persona){
		  global $instancia_conexion ;
		  $sql="SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombres, a.identidad, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, m.modalidad, dp.descripcion AS horario, concat(vap.horario_entrada,' a ',vap.horario_salida) as horas, c.valor Correo, e.valor Celular,cp.nombre, na.descripcion as nivel_a, cp.cargo, cp.correo, cp.telefono, cp.celular, a.id_persona

		  FROM
  
		  tbl_empresas_practica AS ep
		  JOIN tbl_personas AS a
		  ON ep.id_persona = a.id_persona
		  JOIN tbl_practica_estudiantes AS pe
		  ON pe.id_persona = a.id_persona
		  JOIN tbl_evaluaciones_practica AS evp
		  ON evp.id_persona = a.id_persona
		  JOIN tbl_contactos c ON a.id_persona = c.id_persona
		  JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
		  JOIN tbl_contactos e ON a.id_persona = e.id_persona
		  JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
		  JOIN tbl_vinculacion_aprobacion_practica AS  vap ON vap.id_persona = a.id_persona
		  JOIN tbl_contacto_practica AS cp ON cp.persona_id = a.id_persona
          JOIN tbl_nivel_academico AS na ON na.id_nivel_a = cp.nivel_academico
		  JOIN tbl_modalidad AS m ON m.id_modalidad = pe.id_modalidad
		  JOIN tbl_dias_practica AS dp ON dp.id_dias = vap.id_dias
		  JOIN tbl_personas_extendidas AS px on px.id_atributo=12 and px.id_persona=a.id_persona and pe.id_persona='$id_persona' AND evp.numero_visita='Primera Supervisión' AND ep.contacto_id = cp.id;";			return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	
		}
  
	  

}


























?>


