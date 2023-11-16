<?php
include_once '../../configuracion.php';
include_once '../estructura/headLibre.php';
//include_once '../estructura/headPrivado.php';

$datos=data_submitted();
//$datos['password']=md5($datos['password']);

// Validacion 
if($datos['accion']=='login'){
    $session=new Session();
    $salida=$session->iniciar($datos['nombre'],$datos['password']);
    if($salida){
        header("Location: ../grilla/indexGrilla.php");
    }
    else{

        $mensaje="<p class='text-danger'>"." Usted no esta registrado."."</p>";
        echo("<script> location.href='./indexLogin.php?msg=".$mensaje."'</script>");
        header("Location: indexLogin.php");
    }// fin else
}// fin if 

if($datos['accion']=="salir"){
    $resp=$session->cerrar();
    if($resp){
        header("Location: ../../index.php");
    }// fin if
}// fin 

?>