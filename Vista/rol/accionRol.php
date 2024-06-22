<?php
include_once "../../configuracion.php";
$objAbmMenuRol = new AbmMenuRol;
$objAbmRol = new AbmRol();

$datos = data_submitted();

if (isset($datos["accion"]) && $datos["accion"] == 'listarMenus') {
    echo $objAbmMenuRol->listarMenuRol($datos);
}

if (isset($datos["accion"]) && $datos["accion"] == 'editar') {
    echo $objAbmRol->editar($datos);
}

if (isset($datos["eliminar"])) {
 echo $objAbmRol->deshabilitar($datos);
}

if (isset($datos["habilitar"])) {
   echo $objAbmRol->habilitar($datos);
}
