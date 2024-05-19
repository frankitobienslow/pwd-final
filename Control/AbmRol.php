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

} // fin clase 
