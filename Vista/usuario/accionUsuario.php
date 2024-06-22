<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$objAbmUsuarioRol = new AbmUsuarioRol();
$objAbmUsuario=new AbmUsuario;


if (isset($datos["accion"]) && $datos["accion"] == 'listarRoles') {
   echo $objAbmUsuarioRol->listarRoles($datos);
}

if (isset($datos["accion"]) && $datos["accion"] == 'editar') {
   echo $objAbmUsuarioRol->editarRoles($datos);
}

if (isset($datos["eliminar"])) {
    echo $objAbmUsuario->deshabilitar($datos);
}

if (isset($datos["habilitar"])) {
    echo $objAbmUsuario->habilitar($datos);
}

if (isset($datos["accion"]) && $datos["accion"] == 'obtenerClaves') {
    ob_clean();
    echo $objAbmUsuario->obtenerClaves($datos);
}

if (isset($datos["accion"]) && $datos["accion"] == 'editarPerfil') {
    echo $objAbmUsuario->editarPerfil($datos);
}
