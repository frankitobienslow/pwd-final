<?php
include_once '../../configuracion.php';
<<<<<<< HEAD
//include_once '../estructura/headLibre.php';
=======
>>>>>>> 29cc111574f051bc3cfe3d33b81208c46cba229a
//include_once '../estructura/headPrivado.php';

$datos=data_submitted();

// Validacion 
if($datos['accion']=='login'){
    //$datos['password']=md5($datos['password']);
    $session=new Session();
    $salida=$session->iniciar($datos['nombre'],$datos['password']);
    if($salida){
        header("Location: ../grilla/indexGrilla.php?logeado=si");
    }
    else{
        $mensaje="<p class='text-danger'>"." Usted no esta registrado."."</p>";
        echo("<script> $('#error').html($mensaje) </script>");
        echo("<script>console.log($mensaje);</script>");
        header("Location: indexLogin.php?");
    }// fin else
}// fin if 

if($datos['accion']=="cerrar"){
    $resp=$objSession->cerrar();
    
    if($resp){
        header("Location: ../index.php");
    }// fin if
}// fin 

?>


