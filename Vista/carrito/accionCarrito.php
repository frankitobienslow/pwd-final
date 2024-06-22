<?php
include_once '../../configuracion.php';
include_once '../mails/accionMails.php';
$datos = data_submitted();
$objCompraEstado = new AbmCompraEstado();

if (isset($datos["obtenerCarrito"])) {
  echo $objCompraEstado->getCarrito($datos);
}

//Elimina el producto del carrito
if (isset($datos["idEliminar"])) {
   echo $objCompraEstado->eliminarItemsCarrito($datos);
}

if (isset($datos["confirmarCompra"])) {
    echo $objCompraEstado->confirmarCompra($datos);
}
