<?php
include_once '../../configuracion.php';

$datos = data_submitted();
$objAbmUsuario = new AbmUsuario;

// Validacion 
if ($datos['accion'] == 'login') {
    $alphanumeric_regex = '/^[a-zA-Z0-9]+$/';
    $mail_regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $error = '';
    if ($datos["usnombre"] != null && $datos["uspass"] != null && preg_match($alphanumeric_regex, $datos["usnombre"]) && preg_match($alphanumeric_regex, $datos["uspass"])) {
        $datos['uspass'] = hash('sha256', $datos['uspass']);
        $session = new Session();
        $salida = $session->iniciar($datos['usnombre'], $datos['uspass']);
        if ($salida) {
            header("Location: ../grilla/indexGrilla.php");
        } else {
            $error = "1";
            header("Location: indexLogin.php?error=1");
        } // fin else
    } else {
        header("Location: indexLogin.php?error=2");
    }
} // fin if 

if ($datos['accion'] == "cerrar") {
    $session = new Session();
    $resp = $session->cerrar();
    if ($resp) {
        header("Location: ../index.php");
    } // fin if
} // fin 

if ($datos['accion'] == 'nuevo') {
    $alphanumeric_regex = '/^[a-zA-Z0-9]+$/';
    $mail_regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $error = '';
    if ($datos["usnombre"] != null && $datos["uspass"] != null && $datos["usmail"] != null && preg_match($alphanumeric_regex, $datos["usnombre"]) && preg_match($alphanumeric_regex, $datos["uspass"]) && preg_match($mail_regex, $datos["usmail"])) {
        if ($objAbmUsuario->buscar(["usnombre" => $datos["usnombre"]]) != null) {
            $error .= "2";
        }
        if ($objAbmUsuario->buscar(["usmail" => $datos["usmail"]]) != null) {
            $error .= "3";
        }
        if ($error == '') { //Si no hubieron errores
            $objAbmUsuario = new AbmUsuario();
            $datos['uspass'] = hash('sha256', $datos['uspass']);
            $respuesta = $objAbmUsuario->alta($datos);
            if ($respuesta) {
                $objAbmUsuarioRol = new AbmUsuarioRol();
                $usuarios = $objAbmUsuario->buscar(null);
                $data['idusuario'] = end($usuarios)->getId();
                $data['idrol'] = 3;
                $objAbmUsuarioRol->alta($data);
                header("Location: indexLogin.php?");
            }
        } else {
            header("Location: register.php?error=" . $error);
        }
    } else {
        $error .= "1";
        header("Location: register.php?error=" . $error);
    }
}
