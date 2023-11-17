<?php
include_once "../../configuracion.php";
$datos=data_submitted();

$session=new Session();
if(isset($datos['menurol'])){
    $session->setRol($datos['menurol']);
}

?>