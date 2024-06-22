<?php
include_once '../../configuracion.php';

$datos = data_submitted();
$objAbmUsuario = new AbmUsuario;
$objSession=new Session;

// Validacion 
if ($datos['accion'] == 'login') {
  $objAbmUsuario->validarLogin($datos);
} // fin if 

if ($datos['accion'] == "cerrar") {
    $resp = $objSession->cerrar();
    if ($resp) {
        header("Location: ../index.php");
    } // fin if
} // fin 

if ($datos['accion'] == 'nuevo') {
   $objAbmUsuario->nuevoUsuario($datos);
}
