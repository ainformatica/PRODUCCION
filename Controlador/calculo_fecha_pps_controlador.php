<?php
ob_start();
require_once "../Modelos/calculo_fecha_pps_modelos.php";
//recepcion de variables por el metodo POST
$fecha_inicio = $_POST['fecha_inicio'];
$horario_incio = $_POST['horario_incio'];
$horario_fin = $_POST['horario_fin'];
$horario_incio_sab = $_POST['horario_incio_sab'];
$horario_fin_sab = $_POST['horario_fin_sab'];
$dias = $_POST['dias'];
$cb_practica= $_POST['cb_practica'];
$cb_horas_practica= $_POST['cb_horas_practica'];
$fechaN= $_POST['fecha_inicio'];
$txt_estudiante_cuenta=$_POST['txt_estudiante_cuenta'];
$empresa=$_POST['txt_empresa'];
$obs=$_POST['txt_motivo_rechazo'];


//print_r($cb_practica.'-'.$cb_horas_practica.'-'.$fechaN.'-'.$fechaF.'-'.$txt_estudiante_cuenta.'-'.$empresa);
$db= new pruebas();

switch ($_GET["op"])
{
case 'fecha':
           
          
$h1 = date_create($horario_incio);
$h2 = date_create($horario_fin);
$horast = date_diff($h2, $h1);
$horas_diarias = $horast->format('%H') ; //Me da el calculo de horas diarias 
$horas_semanales=($horas_diarias*5);// Me da el calculo de horas semanales
$dias_trabajo= (800/$horas_diarias);//me da el calculo de dias totales de trabajo
$semanas_trabajo=(800/$horas_semanales);//me da el calculo de semanas que va trabajar
$sabados_domingos=($semanas_trabajo*2);//me da la suma de sabados y domigos a tomar en cuenta 
$dias_totales_trabajo=($dias_trabajo+$sabados_domingos);



$fecha_p = date('Y-m-d', strtotime($fecha_inicio. ' + '.$dias_totales_trabajo.' days'));

$fecha_inicial = new DateTime($fecha_inicio);//fecha inicial
$fecha_final = new DateTime($fecha_p);//fecha final

/*$contador_Sabados_Domingos=0;
$contador_dias_habiles=0;
while( $fecha_inicial <= $fecha_final){
    if($fecha_inicial->format('l')== 'Saturday' || $fecha_inicial->format('l')== 'Sunday'){
                  // echo $fecha_inicial->format('y-m-d (D)')."<br/>";
                  $contador_Sabados_Domingos=$contador_Sabados_Domingos+1;//esto me cuenta los dias sabados y domingos
    }
    $fecha_inicial->modify("+1 days");
   

}

$contador_Sabados_Domingos;*/

$rspta=$db->busqueda_fechas($fecha_inicio,$fecha_p);

$dia_feriados=$rspta['fecha'];
$sumFeriados=$dias_totales_trabajo+$dia_feriados;
$fecha_fin= date('Y-m-d', strtotime($fecha_inicio. ' + '.$sumFeriados.' days'));
$diaS= date('l', strtotime($fecha_fin));

if($diaS=='Saturday')
{
    $sumFeriados=$horas+$dia_feriados+2;
    echo $fecha_fin= date('Y-m-d', strtotime($fecha_inicio. ' + '.$sumFeriados.' days'));
}
elseif($diaS=='Sunday')
{
    $sumFeriados=$horas+$dia_feriados+1;
    echo $fecha_fin= date('Y-m-d', strtotime($fecha_inicio. ' + '.$sumFeriados.' days'));
}
else
{
    echo $fecha_fin= date('Y-m-d', strtotime($fecha_inicio. ' + '.$sumFeriados.' days'));
}

        break;

        // case 'update':
        //     $rspta=$db->update_pps($cuenta_estud, $obs_prac, $empresa_prac, $hrs_pps, $fecha_inicio_prac, $fecha_final_prac);
        //     // echo $rspta ? 0 : 1 ;
        //     echo $consulta;
            
        // break;
}
ob_end_flush();
?>
