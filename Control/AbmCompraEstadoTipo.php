<?php

class AbmCompraEstadoTipo{

        /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompraEstadoTipo($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }// fin metodo abmRol

    /**
     * Espera un Array asociativo y devuelve el obj de la tabla
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $obj=null; 
        
        if(array_key_exists('idcompraestadotipo',$datos) && array_key_exists('cetdescripcion',$datos) && array_key_exists('cetdetalle',$datos) && array_key_exists('procantstock',$datos)){
            
            $obj=new CompraEstadoTipo();
            $obj->setear($datos['idcompraestadotipo'],$datos['cetdescripcion'],$datos['cetdetalle']);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return obj
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompraestadotipo'])){
            $obj=new CompraEstadoTipo();
            $obj->setear($datos['idcompraestadotipo'],$datos['cetdescripcion'],$datos['cetdetalle']);

        }// fin if 
        return $obj;

    }// fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return booelan
     */
    private function setadosCamposClaves($datos){
        $resp=false;
        if(isset($datos['idcompraestadotipo'],$datos['cetdescripcion'],$datos['cetdetalle'])){
            $resp=true;

        }// fin if 

        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        $objCI=$this->cargarObjeto($datos);
        if($objCI!=null && $objCI->insertar()){
            $resp=true;

        }// fin if 
        return $resp;

    }// fin function 


    /**
     * METODO ELIMINAR 
     * @param array $datos
     * @return booelan
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCI=$this->cargarObjetoConClave($datos);
            if($objCI!=null && $objCI->eliminar()){
                $resp=true;

            }// fin if 


        }// fin if 

        return $resp; 

    }// fin function 

    /**
     * MOFICAR 
     * @param array $datos
     * @return boolean
     */
    public function modificacion($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCI=$this->cargarObjeto($datos);
            if($objCI!=null && $objCI->modificar()){
                $resp=true; 

            }// fin if 

        }// fin if 

        return $resp; 

    }// fin function 

    /**   
     * METODO BUSCAR  
     * Si el parametro es null, devolverá todos los registros de la tabla auto 
     * si se llena con los campos de la tabla devolverá el registro pedido
     * @param array $param
     * @return array
     */
    public function buscar ($param){
        $objCI=new CompraEstadoTipo();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
            if(isset($param['idcompraestadotipo'])){ // evalua si existe el auto con la primary key
                $where.=" and idcompraestadotipo = ".$param['idcompraestadotipo'];
                if(isset($param['cetdescripcion'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cetdescripcion ='".$param['cetdescripcion'];
                }// fin if 
                if(isset($param['cetdetalle'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cetdetalle ='".$param['cetdetalle']."'";
                }// fin if 

            }// fin if 
        }// fin if
        $arreglo=$objCI->listar($where);
        //var_dump($where); 
        return $arreglo; 

    }// fin funcion     


}// fin de la clase 

?>