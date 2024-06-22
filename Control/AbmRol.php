<?php

class AbmRol
{
    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo abmRol

    /**
     * Espera un Array asociativo y devuelve el obj de la tabla
     * @param array $datos
     * @return Rol
     */
    private function cargarObjeto($datos)
    {
        $obj = null;

        if (array_key_exists('roldescripcion', $datos) && array_key_exists('idrol', $datos) && array_key_exists('habilitado', $datos)) {

            $obj = new Rol();
            $obj->setear($datos['idrol'], $datos['roldescripcion'], $datos["habilitado"]);
        } // fin if 
        return $obj;
    } // fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Rol
     */
    private function cargarObjetoConClave($datos)
    {
        $obj = null;
        if (isset($datos['idrol'])) {
            $obj = new Rol();
            $obj->setear($datos['idrol'], null, $datos["habilitado"]);
        } // fin if 
        return $obj;
    } // fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function seteadosCamposClaves($datos)
    {
        $resp = false;
        if (isset($datos['idrol'])) {
            $resp = true;
        } // fin if 

        return $resp;
    } // fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return int|boolean
     */
    public function alta($datos)
    {
        $resp = false;
        $datos['idrol'] = null;
        $datos["habilitado"] = 1;
        $objRol = $this->cargarObjeto($datos);
        if ($objRol != null && $id = $objRol->insertar()) { // Modifica esta línea
            $resp = $id; // Modifica esta línea
        }
        return $resp;
    } // fin function 

    /**
     * METODO ELIMINAR 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($datos)) {
            $objRol = $this->cargarObjetoConClave($datos);
            if ($objRol != null && $objRol->eliminar()) {
                $resp = true;
            } // fin if 


        } // fin if 

        return $resp;
    } // fin function 

    /**
     * MOFICAR 
     * @param array $datos
     * @return boolean
     */
    public function modificacion($datos)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($datos)) {
            $objRol = $this->cargarObjeto($datos);
            if ($objRol != null && $objRol->modificar()) {
                $resp = true;
            } // fin if 

        } // fin if 

        return $resp;
    } // fin function 

    /**
     * METODO BUSCAR
     * Si el parametro es null, devolverá todos los registros de la tabla rol 
     * si se llena con los campos de la tabla devolverá el registro pedido
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $objNuevoRol = new Rol();
        $where = " true ";
        if ($param <> null) {
            // Va preguntando si existe los campos de la tabla 
            if (isset($param['idrol'])) {
            } // fin if     
            $where .= " and idrol= " . $param['idrol'];
            if (isset($param['roldescripcion'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and roldescripcion = '" . $param['roldescripcion'] . "'";
            } // fin if  
            if (isset($param['habilitado'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and habilitado = " . $param['roldescripcion'];
            } // fin if 

        } // fin if
        $arreglo = $objNuevoRol->listar($where);

        return $arreglo;
    } // fin funcion     

    public function editar($datos){
        $objAbmMenuRol=new AbmMenuRol;
        $objAbmMenu=new AbmMenu;

        $idrol = $datos["idrol"];
        if ($datos["idrol"] != "nuevo") {
            if (preg_match('/^[A-Za-z\s]+$/', $datos["roldescripcion"])) {
                $param["idrol"] = $datos["idrol"];
                $param["roldescripcion"] = $datos["roldescripcion"];
                $param["habilitado"] = $this->buscar(["idrol" => $param["idrol"]])[0]->getHabilitado();
                if ($this->modificacion($param)) {
                    $idrol = $datos["idrol"];
                }
            }
        } else {
            if (preg_match('/^[A-Za-z\s]+$/', $datos["roldescripcion"])) {
                $param["roldescripcion"] = $datos["roldescripcion"];
                echo $idrol = ($this->alta($param));
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

    public function deshabilitar($datos){
        $idrol = intval($datos["eliminar"]);
        if ($idrol != 1 && $idrol != 2 && $idrol != 3 && $idrol != 4 && $idrol > 0) {
            $roldescripcion = $this->buscar(["idrol" => $idrol])[0]->getDescripcion();
            echo ($this->modificacion(["idrol" => $idrol, "habilitado" => 0, "roldescripcion" => $roldescripcion]));
        }
    }

    public function habilitar($datos){
        $idrol = intval($datos["habilitar"]);
        if ($idrol > 0) {
            $roldescripcion = $this->buscar(["idrol" => $idrol])[0]->getDescripcion();
            echo ($this->modificacion(["idrol" => $idrol, "habilitado" => 1, "roldescripcion" => $roldescripcion]));
        }
    }

} // fin clase 
