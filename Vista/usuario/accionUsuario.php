<?php
include_once("../../configuracion.php");
$datos = data_submitted();
$objAbmRol = new AbmRol();
$objAbmUsuarioRol = new AbmMenuRol();
$objAbmUsuarioRol = new AbmUsuarioRol();
$objAbmUsuario = new AbmUsuario();


if (isset($datos["accion"]) && $datos["accion"] == 'listarRoles') {
    $listaUsuarioRol = $objAbmUsuarioRol->buscar(["idusuario" => $datos["idusuario"]]);

    $respuesta = [];
    foreach ($listaUsuarioRol as $usuarioRol) {
        $respuesta[] = ["idrol" => $usuarioRol->getObjRol()->getId()];
    }
    echo json_encode($respuesta);
}

if (isset($datos["accion"]) && $datos["accion"] == 'editar') {
    $idusuario = $datos["idusuario"];
    $arrChecks = $datos["arrChecks"];
    $rolesAsignados = $objAbmUsuarioRol->buscar(["idusuario" => $idusuario]);
    echo json_encode($rolesAsignados);
    $exito = true; // Variable para controlar si la operación fue exitosa

    // Identificar y agregar elementos que faltan
    foreach ($arrChecks as $check) {
        $idrol = $check;
        $encontrado = false;

        // Verificar si el idrol ya está asignado
        foreach ($rolesAsignados as $rolAsignado) {
            if ($rolAsignado->getObjRol()->getId() == $idrol) {
                $encontrado = true;
                break;
            }
        }

        // Si el idrol no está asignado, agregarlo
        if (!$encontrado) {
            // Aquí debes agregar el idusuario correspondiente si es necesario
            $nuevoAcceso = [
                "idusuario" => $idusuario,
                "idrol" => $idrol
            ];
            // Agregar el nuevo acceso
            if (!$objAbmUsuarioRol->alta($nuevoAcceso)) { //Se asigna el nuevo rol
                $exito = false; // Hubo un error, cambiamos el valor de $exito a false
            }
        }
    }

    // Identificar y eliminar elementos que sobran
    foreach ($rolesAsignados as $key => $rolAsignado) {
        $idrol = $rolAsignado->getObjRol()->getId();
        $encontrado = false;

        // Verificar si el idrol está presente en arrChecks
        foreach ($arrChecks as $check) {
            if ($check == $idrol) {
                $encontrado = true;
                break;
            }
        }
        // Si el idrol no está en arrChecks, quitarlo de rolesAsignados
        if (!$encontrado) {
            if (!$objAbmUsuarioRol->baja(["idrol" => $idrol, "idusuario" => $idusuario])) {
                $exito = false; // Hubo un error, cambiamos el valor de $exito a false
            }
        }
    }
    ob_clean();
    echo json_encode($exito); // Devolvemos el resultado (true/false) como respuesta
}

if (isset($datos["eliminar"])) {
    $idusuario = intval($datos["eliminar"]);
    echo $idusuario;
    $objUsuario = $objAbmUsuario->buscar(["idusuario" => $idusuario])[0];
    $usmail = $objUsuario->getMail();
    $uspass = $objUsuario->getPassword();
    $usnombre = $objUsuario->getNombre();
    ob_end_clean();
    echo ($objAbmUsuario->modificacion(["idusuario" => $idusuario, "habilitado" => 0, "usnombre" => $usnombre, "usmail" => $usmail, "uspass" => $uspass]));
}

if (isset($datos["habilitar"])) {
    $idusuario = intval($datos["habilitar"]);
    echo $idusuario;
    $objUsuario = $objAbmUsuario->buscar(["idusuario" => $idusuario])[0];
    $usmail = $objUsuario->getMail();
    $uspass = $objUsuario->getPassword();
    $usnombre = $objUsuario->getNombre();
    ob_clean();
    echo ($objAbmUsuario->modificacion(["idusuario" => $idusuario, "habilitado" => 1, "usnombre" => $usnombre, "usmail" => $usmail, "uspass" => $uspass]));
}
if (isset($datos["accion"]) && $datos["accion"] == 'obtenerClaves') {
    $arrUsuarios = $objAbmUsuario->buscar(null);
    $mails = [];
    $nombres = [];
    $nombreActual = $objAbmUsuario->buscar($datos)[0]->getNombre();
    $mailActual = $objAbmUsuario->buscar($datos)[0]->getMail();
    foreach ($arrUsuarios as $usuario) {
        $nombre = $usuario->getNombre();
        $mail = $usuario->getMail();
        if ($nombre != $nombreActual) {
            array_push($nombres, $nombre);
        }
        if ($mail != $mailActual) {
            array_push($mails, $mail);
        }
    }
    $respuesta = [
        "nombres" => ($nombres),
        "mails" => ($mails)
    ];
    ob_clean();
    echo json_encode($respuesta);
}

if (isset($datos["accion"]) && $datos["accion"] == 'editarPerfil') {
    $idusuario = intval($datos["idusuario"]);
    $objUsuario = $objAbmUsuario->buscar(["idusuario" => $idusuario])[0];
    $usmail = $datos["usmail"];
    $uspass = hash('sha256', $datos['uspass']);
    $usnombre = $datos["usnombre"];
    ob_clean();
    echo ($objAbmUsuario->modificacion(["idusuario" => $idusuario, "habilitado" => 1, "usnombre" => $usnombre, "usmail" => $usmail, "uspass" => $uspass]));
}
