let $selectDocente=document.getElementById('id_docente'),
$alumnos=document.getElementById('txt_asignados');


function ObtenerDatos(charla_id) {
    
    fetch('../api/Contar_docente.php?id='+charla_id)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
        //console.log(data["cupos"]);
        console.log(data['CANTIDAD']);
        $alumnos.setAttribute('Value',data['CANTIDAD'])
       
        //  swal({
        //     title:"Control de Cupos",
        //     text:"Charla con cupos agotados.",
        //     type: "info",
        //     showConfirmButton: true,
            
        //  }); 
          
      
    })
    .catch()

    
}
$selectDocente.addEventListener('change',(e)=>{
    
    ObtenerDatos($selectDocente.value);
   
});





