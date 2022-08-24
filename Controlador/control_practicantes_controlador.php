
<?php
	session_start();
	require_once "../clases/Conexion.php";


 ?>
 <!DOCTYPE html>
 <html>
 <head>
 
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 </head>
	<center><h2>Control de Practicantes</h2></center>
	<table id="example" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">


			<tr>
				<center><td>Nombre Completo</td></center>
				<center><td>Número de cuenta</td></center>
				<center><td>Empresa</td></center>
				<center><td>Dirección</td></center>
				<center><td>Supervisor Asignado</td></center>
				<center><td>Fecha de inicio</td></center>
				<center><td>Fecha de finalización</td></center>
				<center><td>Primera Visita</td></center>
				<center><td>Segunda Visita</td></center>
			</tr>

			<?php

				if(isset($_SESSION['consulta'])){
					if($_SESSION['consulta'] > 0){
						$idp=$_SESSION['consulta'];
						$sql="SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, concat(p.nombres,' ',p.apellidos) as docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, c.valor Correo, e.valor Celular, te.descripcion AS tipoempresa, cp.nombre, na.descripcion AS nivela, cp.cargo, cp.correo, cp.telefono, ti.descripcion AS trabajai, a.id_persona, concat(vap.horario_entrada,' a ',vap.horario_salida) As horas

						FROM

					    tbl_empresas_practica AS ep
						JOIN tbl_personas AS a
						ON ep.id_persona = a.id_persona
						JOIN tbl_practica_estudiantes AS pe
						ON pe.id_persona = a.id_persona
                        JOIN tbl_personas AS p
						ON pe.docente_supervisor = p.id_persona
                        JOIN tbl_vinculacion_aprobacion_practica AS vap
						ON vap.id_persona = a.id_persona
                        JOIN tbl_tipo_empresa AS te
						ON te.id_tipo_empresa = ep.id_tipo_empresa
                        JOIN tbl_contacto_practica AS cp ON cp.persona_id = a.id_persona
                        JOIN tbl_nivel_academico AS na
						ON na.id_nivel_a = cp.nivel_academico
                        JOIN tbl_trabaja_institucion AS ti
						ON ti.id_trabaja_i = ep.id_trabaja_i
						JOIN tbl_contactos c ON a.id_persona = c.id_persona
						JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
						JOIN tbl_contactos e ON a.id_persona = e.id_persona
						JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
                        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona AND ep.contacto_id = cp.id

                        WHERE NOT (pe.docente_supervisor <=> '')";
					}else{
							$sql="SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, concat(p.nombres,' ',p.apellidos) as docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, c.valor Correo, e.valor Celular, te.descripcion AS tipoempresa, cp.nombre, na.descripcion AS nivela, cp.cargo, cp.correo, cp.telefono, ti.descripcion AS trabajai, a.id_persona, concat(vap.horario_entrada,' a ',vap.horario_salida) As horas

							FROM
	
							tbl_empresas_practica AS ep
							JOIN tbl_personas AS a
							ON ep.id_persona = a.id_persona
							JOIN tbl_practica_estudiantes AS pe
							ON pe.id_persona = a.id_persona
							JOIN tbl_personas AS p
							ON pe.docente_supervisor = p.id_persona
							JOIN tbl_vinculacion_aprobacion_practica AS vap
							ON vap.id_persona = a.id_persona
							JOIN tbl_tipo_empresa AS te
							ON te.id_tipo_empresa = ep.id_tipo_empresa
							JOIN tbl_contacto_practica AS cp ON cp.persona_id = a.id_persona
							JOIN tbl_nivel_academico AS na
							ON na.id_nivel_a = cp.nivel_academico
							JOIN tbl_trabaja_institucion AS ti
							ON ti.id_trabaja_i = ep.id_trabaja_i
							JOIN tbl_contactos c ON a.id_persona = c.id_persona
							JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
							JOIN tbl_contactos e ON a.id_persona = e.id_persona
							JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
							join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona AND ep.contacto_id = cp.id
	
							WHERE NOT (pe.docente_supervisor <=> '')";
					}
				}else{
					$sql="SELECT DISTINCT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, concat(p.nombres,' ',p.apellidos) as docente_supervisor, vap.fecha_inicio, vap.fecha_finalizacion, c.valor Correo, e.valor Celular, te.descripcion AS tipoempresa, cp.nombre, na.descripcion AS nivela, cp.cargo, cp.correo, cp.telefono, ti.descripcion AS trabajai, a.id_persona, concat(vap.horario_entrada,' a ',vap.horario_salida) As horas

					FROM

					tbl_empresas_practica AS ep
					JOIN tbl_personas AS a
					ON ep.id_persona = a.id_persona
					JOIN tbl_practica_estudiantes AS pe
					ON pe.id_persona = a.id_persona
					JOIN tbl_personas AS p
					ON pe.docente_supervisor = p.id_persona
					JOIN tbl_vinculacion_aprobacion_practica AS vap
					ON vap.id_persona = a.id_persona
					JOIN tbl_tipo_empresa AS te
					ON te.id_tipo_empresa = ep.id_tipo_empresa
					JOIN tbl_contacto_practica AS cp ON cp.persona_id = a.id_persona
					JOIN tbl_nivel_academico AS na
					ON na.id_nivel_a = cp.nivel_academico
					JOIN tbl_trabaja_institucion AS ti
					ON ti.id_trabaja_i = ep.id_trabaja_i
					JOIN tbl_contactos c ON a.id_persona = c.id_persona
					JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
					JOIN tbl_contactos e ON a.id_persona = e.id_persona
					JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
					join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona AND ep.contacto_id = cp.id

					WHERE NOT (pe.docente_supervisor <=> '')";
				}

				$result=mysqli_query($connection,$sql);
				while($ver=mysqli_fetch_row($result)){

					$datos=$ver[0]."||".
							$ver[1]."||".
							$ver[2]."||".
							$ver[3]."||".
							$ver[4]."||".
							$ver[5]."||".
							$ver[6]."||".
							$ver[7]."||".
							$ver[8]."||".
							$ver[9]."||".
							$ver[10]."||".
							$ver[11]."||".
							$ver[12]."||".
							$ver[13]."||".
							$ver[14]."||".
							$ver[15]."||".
							$ver[16]."||".
							$ver[17];

														
				?>

				<tr>
				<td><center><?php echo $ver[1] ?><br><button class="btn btn-primary btn-xs " data-toggle="modal"  data-target="#modalPracticante" onclick="agregaform_u('<?php echo $datos ?>')">
					Detalles
				</button></center></td>
				<td><center><?php echo $ver[0] ?></center></td>
				<td><center><?php echo $ver[2] ?><br><button class="btn btn-primary btn-xs " data-toggle="modal" data-target="#modalEmpresa" onclick="agregaform('<?php echo $datos ?>')">
					Detalles
				</button></center></td>
				<td><center><?php echo $ver[3] ?></center></td>
				<td><center><?php echo $ver[4] ?></center></td>
				<td><center><?php echo $ver[5] ?></center></td>
				<td><center><?php echo $ver[6] ?></center></td>
				<td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $ver[16];?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
				<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $ver[16]?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
				</tr>
				<?php
			}
				?>
			</table>


		</html>
<script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js" ></script>
<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable();
} );
</script>


