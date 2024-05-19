<?php

class AbmMenuRol
{

    /**
     * Espera como parametro un arreglo asociativo donde 
     * las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('idmenu', $param) and array_key_exists('idrol', $param)) {
            $objMenu = new Menu();
            $objRol = new Rol();
            $objMenu->setId($param['idmenu']);
            $objRol->setId($param['idrol']);
            $objMenu->cargar();
            $objRol->cargar();
            $obj = new MenuRol();
            $obj->setear($objMenu, $objRol);
        }
        return $obj;
    } // fin metodo

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objMenuRol = null;
        //print_R ($param);
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $objMenuRol = new MenuRol();
            $objMenuRol->setear($param['idmenu'], $param['idrol']);
        }
        return $objMenuRol;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idmenu']) && isset($param['idrol']));
        $resp = true;
        return $resp;
    } // fin metodo


    /**
     *
     * @param array $param
     */
    public function alta($param)
    {
        //  echo "entramos a alta";
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);
        // verEstructura($elObjtAuto);
        //print_r($objMenuRol);
        if ($objMenuRol != null) {
            if ($objMenuRol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo    


    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */

    public function baja($param)
    {
        //verEstructura($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null and $objMenuRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo 



    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null and $objMenuRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo 


    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu'])) {
                $where .= " and idmenu=" . $param['idmenu'];
            }
            if (isset($param['idrol'])) {
                $where .= " and idrol =" . $param['idrol'];
            }
        } // fin if 

        $objMenuRol = new MenuRol();
        $arreglo = $objMenuRol->listar($where);
        return $arreglo;
    } // fin metodo


    function menuPrincipal($objSession)
    {
        $menu = "";
        // GENERACION DEL MENU DINAMICO 
        $param['idrol'] = $objSession->getRolActual()->getId();
        $listaMenuRol = $this->buscar($param);
        $listaPadre = array();
        $listaHijos = array();
        $carrito = '';

        foreach ($listaMenuRol as $obj) {
            if ($obj->getObjMenu()->getNombre() != '') {
                if ($obj->getObjMenu()->getObjMenuPadre() == null) {
                    array_push($listaPadre, $obj->getObjMenu());
                } // fin if 
                else {
                    array_push($listaHijos, $obj->getObjMenu());
                } // fin else
            }
        } // fin for 

        foreach ($listaPadre as $objMenuPadre) {
            $tieneHijos = false;
            foreach ($listaHijos as $objMenuHijo) {
                if ($objMenuHijo->getObjMenuPadre()->getId() == $objMenuPadre->getId()) {
                    $tieneHijos = true;
                    break;
                }
            }
            if ($tieneHijos) {
                $menu .= '<li class="nav-item dropdown">';
                $menu .= '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                $menu .= $objMenuPadre->getNombre() . '</a><ul class="dropdown-menu">';
            } else {
                if ($objMenuPadre->getNombre() == "Carrito") {
                    $carrito = '<li class="navbar-item">
                    <a class="nav-link" id="botonCarrito" href="../carrito/carrito.php"  role="button" aria-expanded="false"><i class="bi bi-cart"></i></a> 
                    </li>  ';
                } else {
                    $menu .= '<li class="nav-item"><a class="nav-link" href="' . $objMenuPadre->getDescripcion() . '">';
                    $menu .= $objMenuPadre->getNombre() . '</a></li>';
                }

                continue; // Salta al siguiente elemento de $listaPadre
            }

            // Agregar los hijos correspondientes
            foreach ($listaHijos as $objMenuHijo) {
                if ($objMenuHijo->getObjMenuPadre()->getId() == $objMenuPadre->getId()) {
                    $menu .= '<li><a class="dropdown-item" href="' . $objMenuHijo->getDescripcion() . '">' . $objMenuHijo->getNombre() . '</a></li>';
                }
            }
            $menu .= '</ul></li>';
        }


        // Agregar la opción de rol al menú

        //if(count($objSession->getUsuario()->getRolUsuarios())>1){

        $listaRol = $objSession->getRol();
        if (count($listaRol) > 1) {
            $opcionRol = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"  data-bs-toggle="dropdown" aria-expanded="false">Elegir rol</a><ul class="dropdown-menu">';
            foreach ($listaRol as $rol) {
                $opcionRol .= '<li><a href="javascript:;" onclick="RealizaMenu(' . $rol->getId() . ');window.location.reload();return false; " class="dropdown-item" > ' . $rol->getDescripcion() . '</a></li>';
            }
            $menu .= $opcionRol . '</ul></li>';
        }

        // }
        if ($carrito != '') {
            $menu .= $carrito;
        }
        return $menu;
    }
} // fin AbmMenuRol
