<?php

class AbmMenuRol
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */

    private function cargarObjeto($param)
    {
        //verEstructura($param);
        $objMenuRol = null;
        $objRol = null;
        $objMenu = null;
        //print_r($param);
        if (array_key_exists('idrol', $param) && array_key_exists('idmenu', $param)) {
            $objRol = new Rol();
            $objRol->setId($param['idrol']);
            $objMenu = new Menu();
            $objMenu->setId($param['idmenu']);
            $objMenuRol = new MenuRol();
            $objMenuRol->setear($objMenu, $objRol);
        }
        return $objMenuRol;
    }
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
            $objMenuRol->setear($param['idmenu'], $$param['idrol']);
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
    }

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
    }

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
            $objMenuRol = $this->cargarObjetoConClave($param);
            if ($objMenuRol != null and $objMenuRol->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

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
    }


    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
            $where .= " and idmenu=" . $param['idmenu'] ;
            if (isset($param['idrol']))
            $where .= " and idrol =" . $param['idrol'] ;
        }
        $objUserRol=new MenuRol();
        $arreglo = $objUserRol->listar($where);
        return $arreglo;
    }

    public function darDescripcionRoles($arrayMenus){
        $rolesUs = [];
        foreach ($arrayMenus as $us) {
            $param['idmenu'] = $us->getidmenu();
            array_push($rolesUs, $this->buscar($param)); 
        }
        $rolesDesc = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            //aca me devuelve el array de roles de cada Menu:
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getRolDescripcion();
                array_push($roles, $rol);
            }
            array_push($rolesDesc, $roles);
        }
        return $rolesDesc;
    }

    public function daridroles($arrayMenus){
        $rolesUs = [];
        foreach ($arrayMenus as $us) {
            $param['idmenu'] = $us->getidmenu();
            array_push($rolesUs, $this->buscar($param)); //esto me devuelve un array de objetos Menu +rol
        }
        $rolesId = [];
        foreach ($rolesUs as $rolUs) {
            $roles = [];
            //aca me devuelve el array de roles de cada Menu:
            foreach ($rolUs as $rolU) {
                $rol = $rolU->getRol()->getidrol();
                array_push($roles, $rol);
            }
            array_push($rolesId, $roles);
        }
        return $rolesId;
    }

}
