<?php

class AbmCompra{

    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompra($datos){
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
        echo("entro cragar objeto");
        if(array_key_exists('idcompra',$datos) && array_key_exists('cofecha',$datos) && array_key_exists('idusuario',$datos)){
            
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusuario']); 
            $objU->cargar(); 
            // creo al obj compra 
            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Compra
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompra'])){
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusario']);
            $objU->cargar(); 

            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);

        }// fin if 
        return $obj;

    }// fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function setadosCamposClaves($datos){
        $resp=false;
        var_dump($datos);
        if(isset($datos['idcompra']) && isset($datos['cofecha']) && isset($datos['idusuario'])){
            echo("entro isset");
            $resp=true;

        }// fin if 
        var_dump($resp);
        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        $datos['idcompra']=null;
        $objCompra=$this->cargarObjeto($datos);
        //echo("alta <br>");
       // var_dump($objCompra);
        if($objCompra!=null && $objCompra->insertar()){
            //echo("<br> true <br>");
            $resp=true;
        }// fin if 
        return $resp;

    }// fin function 

    /**
     * PERMITE ELIMINAR UN OBJ 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCompra=$this->cargarObjetoConClave($datos);
            if($objCompra!=null && $objCompra->eliminar()){
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
            $objCompra=$this->cargarObjeto($datos);
           // var_dump($this->cargarObjeto($datos));
            if($objCompra!=null && $objCompra->modificar()){
         
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
        $objCompra=new Compra();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
            if(isset($param['idcompra'])){ // evalua si existe el auto con la primary key
                $where.=" and idcompra=".$param['idcompra'];
                if(isset($param['cofecha'])){// identifica si esta la clave (atributo de la tabla)
                    $where.="and cofecha ='".$param['cofecha']."'";
                }// fin if 
                if(isset($param['idusuario'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idusuario =".$param['idusuario'];
                }// fin if 

            }// fin if 
        }// fin if
        $arreglo=$objCompra->listar($where);
        //var_dump($where); 
        return $arreglo; 

<<<<<<< HEAD
    }// fin funcion   
=======
    }// fin funcion     

        /** METODO MODIFICAR ESTADO DE LA COMPRA
     * En funcion del id de la tabla cambio de estado tipo al que quiero ir  y el obj compra 
    * realiza la modifcacion 
     * @param Compra
     * @param int idCET
     *@return boolean 
     */
    public function modificarEstadoCompra($objCompra,$idCET){
        $idCompra = $objCompra->getId();
        $fechaFinCompraEstado=date('Y-m-d H:i:s'); // inicia la fecha y hora de la compra
        $objCompraEstado =new AbmCompraEstado();
        $datos  =['idcompra'=>$idCompra, 'cefechafin'=>null];
        // llamo a la ultima compra con la fecha fin nula 
        $ultimoEstadoCompra = $objCompraEstado->buscar($datos);
        $ultimoEstadoCompra=$ultimoEstadoCompra[0];
        
        if($ultimoEstadoCompra==null){ // es la primera compra (solo se da de alta)
            $cambioDeDatos = ['idcompra'=>$idCompra,'idcompraestadotipo'=>1,
            'cefechaini'=>$fechaFinCompraEstado,'cefechafin'=>null];
            $resp1=$objCompraEstado->alta($cambioDeDatos);

        }// fin if 
        else{
            $cambioDeDatos = ['idcompra'=>$idCompra,'idcompraestadotipo'=>$ultimoEstadoCompra->getObjCompraEstadoTipo()->getId(),
            'cefechaini'=>$ultimoEstadoCompra->getFechaInicio(),'cefechafin'=>$fechaFin];
            $resp1=$ultimoEstadoCompra->modificacion($cambioDeDatos);
>>>>>>> 89ce9a56ad45d4b00ca61e125afbcf4a68c495fd
    
    
<<<<<<< HEAD
}// fin clase AbmCmpra
=======
    if(array_key_exists('idusuario',$productosUsuario) && array_key_exists('idproducto',$productosUsuario)){
        // creacion de la nueva compra 
        $objCompra=new AbmCompra();
        $listaCompras=$objCompra->buscar(null);
        $idCompra=$listaCompras[count($listaCompras)]->getId() + 1; // aumenta en 1 el id de la nueva compra
        $fechaInicioCompra=date('Y-m-d H:i:s'); // inicia la fecha y hora de la compra 
        $datosCompra=['idcompra'=>$idCompra,'cofecha'=>$fechaInicioCompra,'idusuario'=>$productosUsuario['idusuario']];
        $objCompra->alta($datosCompra); // alta  a nueva compra
        
        // cambio en el estado de la compra
        $respuesta=$objCompra->modificarEstadoCompra($objCompra,1);
        if(!$respuesta){
            $objCompra=null;
        } // fin if 
    }// fin if 
    return $objCompra; 


}// fin function 

/**
 * METODO FINALIZAR COMPRA 
 * @param Compra
 * @param array productos (array de  idproductos y cantidad )
 * @return int   (id compra )
 */
public  function finalizarCompra($objCompra,$productos){
    // creo un obj compra estado para pasar a compra aceptada
    $objCompraEstado=new AbmCompraEstado();
    $fechaFin=date('Y-m-d H:i:s'); // 
    $parametros =['idcompra'=>$objCompra->getId(),'cefechafin'=>null];
    $listaCompraEstadoAnterior=$objCompraEstado->buscar($parametros); // busca con el id compra y fecha fin null 
   // obj de compraEstado (inicializada)
    $estadoCompraAnterior = $listaCompraEstadoAnterior[0]; 
    $lista = $objCompraEstado->buscar(null);    

    $idCompraEstado=$lista[count($lista)]->getId() + 1;

    // creacion del obj compra estado tipo 
    $objCET = new AbmCompraEstadoTipo();
    $compraEstadoTipo = $objCET->buscar(['idcompraestadotipo'=>2]);

    // Carga de los adtos para crear el nuevo estado de la compra  ( id compra estado tipo = 2 significa que la compra fue aceptada)
    // DATOS PARA ES ESTADO-COMPRA ANTERIOR     
    $datosCompraEstado1=['idcompraestado'=>$estadoCompraAnterior->getId(),'idcompra'=>$objCompra->getId(),
    'idcompraestadotipo'=>$compraEstadoTipo[0]->getId(),
    'cefechaini'=>$fechaFin,'cefechafin'=>$fechaFin];
    // DATOS PARA ESTADO-COMPRA NUEVA
    $datosCompraEstado2=['idcompraestado'=>$idCompraEstado,'idcompra'=>$objCompra->getId(),
    'idcompraestadotipo'=>$compraEstadoTipo[0]->getId(),
    'cefechaini'=>$fechaFin,'cefechafin'=>null];

    // modificacion del estado de la compra anterior (inicializada)
    $estadoCompraAnterior->modificacion($datosCompraEstado1);

    // alta al nuevo estado de la compra 
    $objCompraEstado->alta($datosCompraEstado2);    


     // creo el obj de compraItem  UNA COMPRA TIENE VARIOS ITEMS COMPRA, HAY QUE RECORRERLO

    // creacion de los obj compra item en funcion de la cantidad de productos comprados
    $cantProductos=count($productos);
    for($i=0; $i<$cantProductos; $i++){
        $objCompraItem = new AbmCompraItem();

        // busco los items que tengan las mismas id compra 
        $listaComprasItem=$objCompraItem->buscar(['idcompra'=>$objCompra->getId()]); 
        $idCompraItem=$listaComprasItem[count($listaComprasItem)]->getId() + 1; 

        // llenado de los datos necesarios para dar de alta al objcompraItem
        $datosCompraItem=['idcompraitem'=>$idCompraItem,'idproducto'=>$productos[$i]['idproducto'],
        'idcompra'=>$objCompra->getId(),'cicantidad'=>$productos[$i]['cantidad']];
        
        // EL STOCK LO TENGO QUE VERIFICAR CON AJAX DIRECTAMENTE EN EL CARRITO
        // modificacion del stock del producto
        $objProducto=new AbmProducto();
        $unProducto = $objProducto->buscar($productos[$i]['idproducto']);
        $unProducto[0]->set( $unProducto[0]->getStock() - $productos[$i]['cantidad']);
        $objCompraItem->alta($datosCompraItem); 

    }// fin for 

    return $objCompra->getId(); 


}// fin metodo 


/** METODO CANCELAR COMPRA
 * @param object compra
 * @param array producto
 * @return boolean
 */
 function cancelarCompra($objCompra,$productos){
    $idCET = 4; // cancelacion de la compra 
    $fechafin=date('Y-m-d H:i:s'); // guarda la fecha de cancelacion 
    // creacion de un obj estadoCompra
    $objEstadoCompra=new AbmCompraEstado();
    $objCompraItem = new AbmCompraItem();
    $objProducto = new AbmProducto();
    $listaEstadoCompra=$objEstadoCompra->buscar(null);
    $idEC=$listaEstadoCompra[count($listaEstadoCompra)]->getId()+1;
    
    $comprasConId=$objEstadoCompra->buscar(['idcompra' => $objCompra->getId()]);
    // recupero el ultimo idcompra de la tabla  estado compra 
    $last=count($comprasConId);
    $datosEstadoCompra=['idcompraestado'=>$idEC,'idcompra'=>$objCompra->getId(),
    'idcompraestadotipo'=>$idCET,'cefechaini'=>$listaEstadoCompra[$last]->getFechaFin(),'cefechafin'=>$fechafin];
    $salida= $objEstadoCompra->alta($datosEstadoCompra);// armo los datos para  ingresar un nuevo estado de la compra (cancelado) 
    if($salida){
        $compraItem = $objCompraItem->buscar(['idcompra'=>$objCompra->getId()]);
        // vuelvo agregar la cantidad a la base de datos 
        foreach($compraItem as $unItem){
            $product = $objProducto->buscar(['idproducto'=>$unItem['idproducto']]); // obtengo el producto que coincide con el id producto de la tabla compra item
            $product[0]['procantstock']+=$unItem['cicntidad'];
            $objProducto->modificacion($product[0]);

        }// fin for 

    }// fin if 

   return $salida; 
}// fin metodo cancelar


}// FIN DE LA CLASE  


?>
>>>>>>> 89ce9a56ad45d4b00ca61e125afbcf4a68c495fd
