<?php
include_once "../../configuracion.php";
$objAbmMenuRol = new AbmMenuRol;
$objAbmRol = new AbmRol();
$objAbmMenu = new AbmMenu();

$datos = data_submitted();

if (isset($datos["accion"]) && $datos["accion"] == 'listarMenus') {
    $listaMenuRol = $objAbmMenuRol->buscar(["idrol" => $datos["idrol"]]);

    $respuesta = [];
    foreach ($listaMenuRol as $menuRol) {
        $respuesta[] = ["idrol" => $menuRol->getObjRol()->getId(), "idmenu" => $menuRol->getObjMenu()->getId()];
    }
    echo json_encode($respuesta);
}


if (isset($datos["accion"]) && $datos["accion"] == 'editar') {
    $idrol = $datos["idrol"];
    if ($datos["idrol"] != "nuevo") {
        if (preg_match('/^[A-Za-z\s]+$/', $datos["roldescripcion"])) {
            $param["idrol"] = $datos["idrol"];
            $param["roldescripcion"] = $datos["roldescripcion"];
            $param["habilitado"] = $objAbmRol->buscar(["idrol" => $param["idrol"]])[0]->getHabilitado();
            if ($objAbmRol->modificacion($param)) {
                $idrol = $datos["idrol"];
            }
        }
    } else {
        if (preg_match('/^[A-Za-z\s]+$/', $datos["roldescripcion"])) {
            $param["roldescripcion"] = $datos["roldescripcion"];
            echo $idrol = ($objAbmRol->alta($param));
            $objAbmMenuRol->alta(["idrol" => $idrol, "idmenu" => 51]);
            $objAbmMenuRol->alta(["idrol" => $idrol, "idmenu" => 56]);
        }
    }
    $arrChecks = ($datos["arrChecks"]);
    $menusAsignados = $objAbmMenuRol->buscar(["idrol" => $idrol]);
    // Identificar y agregar elementos que faltan
    foreach ($arrChecks as $check) {
        $idmenu = $check;
        $encontrado = false;

        // Verificar si el idmenu ya está asignado
        foreach ($menusAsignados as $menuAsignado) {
            if ($menuAsignado->getObjMenu()->getId() == $idmenu) {
                $encontrado = true;
                break;
            }
        }

        // Si el idmenu no está asignado, agregarlo
        if (!$encontrado) {
            // Aquí debes agregar el idrol correspondiente si es necesario
            $nuevoAcceso = [
                "idrol" => $idrol,
                "idmenu" => $idmenu
            ];
            // Agregar el nuevo acceso
            if ($objAbmMenuRol->alta($nuevoAcceso)) { //Se asigna el nuevo menu
                $objPadre = $objAbmMenu->buscar(["idmenu" => $nuevoAcceso["idmenu"]])[0]->getobjMenuPadre();
                if ($objPadre != null && $objPadre->getId() == 1) { //Si el nuevo menu asignado es hijo de Configuracion
                    if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 1])) == 0) {
                        $objAbmMenuRol->alta(["idrol" => $idrol, "idmenu" => 1]); //Tambien se asigna el menu "Configuracion"
                    }
                }
                if ($nuevoAcceso["idmenu"] == 35) { //Si el nuevo menu asignado es "Mis Compras"
                    if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 53])) == 0) {
                        $objAbmMenuRol->alta(["idrol" => $idrol, "idmenu" => 53]); //Tambien se asigna el menu "Ver detalles"
                    }
                } else if ($nuevoAcceso["idmenu"] == 32) { //Si el nuevo menu asignado es "Ventas"
                    if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 55])) == 0) {
                        $objAbmMenuRol->alta(["idrol" => $idrol, "idmenu" => 55]); //Tambien se asigna el menu "Ver detalles"
                    }
                }
            }
        }
    }

    // Identificar y eliminar elementos que sobran
    foreach ($menusAsignados as $key => $menuAsignado) {
        $idmenu = $menuAsignado->getObjMenu()->getId();
        $encontrado = false;

        // Verificar si el idmenu está presente en arrChecks
        foreach ($arrChecks as $check) {
            if ($check == $idmenu) {
                $encontrado = true;
                break;
            }
        }

        // Si el idmenu no está en arrChecks, quitarlo de menusAsignados
        if (!$encontrado && $idmenu != 1 && $idmenu != 53 && $idmenu != 55 && $idmenu != 51 && $idmenu != 56) {
            if ($idrol != 1 || $idmenu != 25) { //No permite eliminar Gestion de roles del rol administrador
                if ($objAbmMenuRol->baja(["idmenu" => $idmenu, "idrol" => $idrol])) {
                    $objPadre = $objAbmMenu->buscar(["idmenu" => $idmenu])[0]->getobjMenuPadre();
                    if ($idmenu == 35) { //Si el menu dado de baja es "Mis Compras"
                        if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 53])) != 0) {
                            $objAbmMenuRol->baja(["idrol" => $idrol, "idmenu" => 53]); //Tambien se da de baja el menu "Ver detalles"
                        }
                    } else if ($idmenu == 32) { //Si el menu dado de baja es "Ventas"
                        if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 55])) != 0) {
                            $objAbmMenuRol->baja(["idrol" => $idrol, "idmenu" => 55]); //Tambien se da de baja el menu "Ver detalles"
                        }
                    } else if ($objPadre != null && $objPadre->getId() == 1) { //Si el menu dado de baja es hijo de configuracion
                        if (count($objAbmMenuRol->buscar(["idrol" => $idrol, "idmenu" => 12])) == 0 && count($objAbmMenuRol->buscar(["idrol" => $datos["idrol"], "idmenu" => 22])) == 0 && count($objAbmMenuRol->buscar(["idrol" => $datos["idrol"], "idmenu" => 25])) == 0) { //Y ya no tiene mas hijos asignados
                            $objAbmMenuRol->baja(["idrol" => $idrol, "idmenu" => 1]); //Tambien se da de baja el menu "Configuracion"
                        }
                    }
                }
            } else {
                ob_clean();
                echo "errorGestionRol";
            }
        }
    }
}

if (isset($datos["eliminar"])) {
    $idrol = intval($datos["eliminar"]);
    if ($idrol != 1 && $idrol != 2 && $idrol != 3 && $idrol != 4 && $idrol > 0) {
        $roldescripcion = $objAbmRol->buscar(["idrol" => $idrol])[0]->getDescripcion();
        echo ($objAbmRol->modificacion(["idrol" => $idrol, "habilitado" => 0, "roldescripcion" => $roldescripcion]));
    }
}

if (isset($datos["habilitar"])) {
    $idrol = intval($datos["habilitar"]);
    if ($idrol > 0) {
        $roldescripcion = $objAbmRol->buscar(["idrol" => $idrol])[0]->getDescripcion();
        echo ($objAbmRol->modificacion(["idrol" => $idrol, "habilitado" => 1, "roldescripcion" => $roldescripcion]));
    }
}
