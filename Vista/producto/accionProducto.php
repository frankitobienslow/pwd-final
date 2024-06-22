<?php
include_once("../../configuracion.php");
$datos = $_POST;
$abmProducto=new AbmProducto;


if (isset($datos["eliminar"])) { //Logica eliminar
     echo $abmProducto->eliminar($datos);
}

if (isset($datos["productoEliminar"])) { //Logica para deshabilitar un producto y cancelar las compras asociadas
   echo $abmProducto->deshabilitar($datos);
}

//Logica editar/nuevo
if (isset($datos["idproducto"])) {
    echo $abmProducto->editar($datos);
}

if (isset($datos["habilitar"])) {
    echo $abmProducto->habilitar($datos);
}

