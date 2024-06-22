<?php
ob_start();
include_once("../../configuracion.php");
$datos = data_submitted();
$objAbmCompra = new AbmCompra;

if (isset($datos["accion"])) {
    echo $objAbmCompra->getCarrito($datos);
}

//Si se agregó un producto...
if (isset($datos["idAgregar"])) {
   echo $objAbmCompra->agregarProducto($datos);
}



