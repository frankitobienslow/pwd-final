<?php
include_once '../../configuracion.php';
include_once '../mails/accionMails.php';

$datos = data_submitted();
$objCE = new AbmCompraEstado();

if (isset($datos["procesarVenta"])) {
   echo $objCE->procesarVenta($datos);
}

//Logica entregar compra
if (isset($datos["idcompraEnviar"])) {
    echo $objCE->entregarVenta($datos);
}

//Logica cancelar compra por el usuario (cuando esta en pendiente)
if (isset($datos["cancelarCompra"])) {
    echo $objCE->cancelarCompra($datos);
}

//Logica aceptar compra por el usuario (cuando esta en pendiente)
if (isset($datos["aceptarCompra"])) {
   echo $objCe->aceptarCompra($datos);
}
