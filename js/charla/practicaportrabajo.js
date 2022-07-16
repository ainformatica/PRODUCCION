let $solicitud=document.getElementById("txt_solicitud"),
$form= document.getElementById("frmPracticaTrabajo");

$form.addEventListener('submit',(e)=>{
   e.preventDefault();
//   ($solicitud.value!='') console.log('Mandar')?
//    :console.log('No Mandar');

if($solicitud.value!=''){
$form.submit();
}
else{
    swal({
        title: "",
        text: "Recuerda cagar tu archivo: ",
        type: "warning",
        showConfirmButton: false,
        timer: 2000
      });

}
    
   
})


