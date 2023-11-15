<?php
include_once '../../configuracion.php';
include_once '../estructura/headLibre.php';

$datos=data_submitted();
$datos['password']=md5($datos['password']);
// Validacion 
if($datos['accion']=='login'){
    $session=new Session();
    $salida=$session->iniciar($datos['nombre'],$datos['password']);
    if($salida){
        header("Location: ../grilla/indexGrilla.php");
    }
    else{
        $mensaje="<p class='text-danger'>"." Usted no esta registrado."."</p>";
        echo("<script> location.href='./index.php?msg=".$mensaje."'</script>");
        header("Location: index.php");
    }// fin else
}// fin if 

if($datos['accion']=="salir"){
    $resp=$session->cerrar();
    if($resp){
        header("Location: ../inicio/inicioIndex.php");
    }// fin if
}// fin 

?>