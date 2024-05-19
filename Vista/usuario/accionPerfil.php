<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$objAbmUsuario=new AbmUsuario();

echo $datos["accion"];