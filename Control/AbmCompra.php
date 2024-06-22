<?php

class AbmCompra
{

    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompra($datos)
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
     * @return object
     */
    private function cargarObjeto($datos)
    {
        $obj = null;
        //echo("entro cragar objeto");
        if (array_key_exists('idcompra', $datos) && array_key_exists('cofecha', $datos) && array_key_exists('idusuario', $datos)) {

            // creo al obj usuario
            $objU = new Usuario();
            $objU->setId($datos['idusuario']);
            $objU->cargar();
            // creo al obj compra 
            $obj = new Compra();
            $obj->setear($datos['idcompra'], $datos['cofecha'], $objU);
        } // fin if 
        return $obj;
    } // fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Compra
     */
    private function cargarObjetoConClave($datos)
    {
        $obj = null;
        if (isset($datos['idcompra'])) {
            // creo al obj usuario
            $objU = new Usuario();
            $objU->setId($datos['idusuario']);
            $objU->cargar();

            $obj = new Compra();
            $obj->setear($datos['idcompra'], $datos['cofecha'], $objU);
        } // fin if 
        return $obj;
    } // fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function setadosCamposClaves($datos)
    {
        $resp = false;
        // var_dump($datos);
        if (isset($datos['idcompra']) && isset($datos['cofecha']) && isset($datos['idusuario'])) {
            echo ("entro isset");
            $resp = true;
        } // fin if 
        //var_dump($resp);
        return $resp;
    } // fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos)
    {
        $resp = false;
        $datos['idcompra'] = null;
        $objCompra = $this->cargarObjeto($datos);
        //echo("alta <br>");
        // var_dump($objCompra);
        if ($objCompra != null && $objCompra->insertar()) {
            //echo("<br> true <br>");
            $resp = true;
        } // fin if 
        return $resp;
    } // fin function 

    /**
     * PERMITE ELIMINAR UN OBJ 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos)
    {
        $resp = false;
        if ($this->setadosCamposClaves($datos)) {
            $objCompra = $this->cargarObjetoConClave($datos);
            if ($objCompra != null && $objCompra->eliminar()) {
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

        if ($this->setadosCamposClaves($datos)) {
            $objCompra = $this->cargarObjeto($datos);
            // var_dump($this->cargarObjeto($datos));
            if ($objCompra != null && $objCompra->modificar()) {

                $resp = true;
            } // fin if 

        } // fin if 

        return $resp;
    } // fin function 

    /**
     * METODO BUSCAR
     * Si el parametro es null, devolverá todos los registros de la tabla auto 
     * si se llena con los campos de la tabla devolverá el registro pedido
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $objCompra = new Compra();
        $where = " true ";
        if ($param <> null) {
            // Va preguntando si existe los campos de la tabla 
            if (isset($param['idcompra'])) {
                $where .= " and idcompra=" . $param['idcompra'];
            } // fin if 
            if (isset($param['cofecha'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= "and cofecha ='" . $param['cofecha'] . "'";
            } // fin if 
            if (isset($param['idusuario'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and idusuario =" . $param['idusuario'];
            } // fin if 
        } // fin if
        $arreglo = $objCompra->listar($where);
        //var_dump($where); 
        return $arreglo;
    } // fin funcion   

    public function getCarrito($datos)
    {
        $objAbmCompraEstado = new AbmCompraEstado;
        $objAbmCompraItem = new AbmCompraItem;
        $session = new Session;
        $comprasUsuario = $this->buscar(["idusuario" => $session->getUsuario()->getId()]);
        $carrito = 0;
        if ($comprasUsuario != null) {
            foreach ($comprasUsuario as $compra) {
                if ($objAbmCompraEstado->buscar(["idcompra" => $compra->getId(), "idcompraestadotipo" => 1, "cefechafin" => "null"]) != null) {
                    if ($objAbmCompraItem->buscar(["idcompra" => $compra->getId()]) != null) {
                        $carrito = 1;
                        break;
                    }
                }
            }
        }
        ob_clean();
        echo $carrito;
    }

    public function agregarProducto($datos)
    {
        $error = false;
        $session = new Session;
        $objCompraEstado = new AbmCompraEstado();
        $objProducto = new AbmProducto();
        $objCompraItem = new AbmCompraItem;
        $datosP["idproducto"] = $datos["idAgregar"];
        $stockProducto = $objProducto->buscar($datosP)[0]->getStock();

        if ($stockProducto > 0) { //Si el producto seleccionado está en stock...
            $datosCE["idusuario"] = $session->getUsuario()->getId(); //Se obtiene el ID del usuario
            $comprasDelUsuario = $this->buscar($datosCE);    //Busca las compras que hizo el usuario
            $cantCompras = count($comprasDelUsuario); //Obtiene la cantidad de esas compras
            $param["idcompraestadotipo"] = 1; //Declara que se buscará el idcompraestadotipo=1
            $param["cefechafin"] = "null";
            $seEncontro = false;
            for ($i = 0; $i < $cantCompras; $i++) { //Itera entre las compras
                $param["idcompra"] = $comprasDelUsuario[$i]->getId(); //Para cada una guarda su ID como clave de param        
                $compraEncontrada = $objCompraEstado->buscar($param); //Obtiene la coleccion de compras cuyo idcompraestadotipo sea 1 (en el carrito) siempre sera una o ninguna
                if (count($compraEncontrada) != 0) { //Si la longitud de la direccion no es 0 (tiene un carrito iniciado)
                    $datosCI['idcompra'] = $param["idcompra"];
                    $datosCI['idproducto'] = $datos['idAgregar'];
                    $itemCompra = $objCompraItem->buscar($datosCI);
                    if (count($itemCompra) > 0) {
                        if ($stockProducto <= $itemCompra[0]->getCantidad()) { //Si el stock de ese producto es mayor a la cantidad de unidades que ya estan en el carrito
                            $error = true; //Caso contrario $error=true
                        } else {
                            $datosCE["idcompra"] = $param["idcompra"]; //Se guarda el idcompra como clave de $datosCE
                        }
                    }
                    $seEncontro = true;
                }
                if ($seEncontro) {
                    break;
                }
            }
            if ($seEncontro) { //Si está definida la clave idcompra en $datosCE (tiene un carrito en curso)
                $this->cargarProducto($datosCI['idcompra'], $datos["idAgregar"]); //Se invoca la funcion cargarProducto
                ob_clean();
                echo "Se agregó el producto.";
            } else if (!$error) { //Si el usuario no realizó compras
                $this->crearCompra($datos["idAgregar"]); //Se crea una nueva compra con idcompraestadotipo=1
                ob_clean();
                echo "Se inició una nueva compra.";
            }
        } else {
            $error = true; //Si el producto seleccionado tiene stock=0, $error=true
        }
        if ($error) {
            ob_clean();
            echo "No se puede agregar este producto. (No hay stock)"; //Si $error es true se notifica al usuario
        }
    }

    function cargarProducto($idCompra, $idProducto)
    {
        // Creacion de obj compraItem
        $objCompraItem = new AbmCompraItem();
        $datosCI['idcompra'] = $idCompra;
        $datosCI['idproducto'] = $idProducto;
        $itemCompra = $objCompraItem->buscar($datosCI); //Se busca si el producto ya es un itemCompra de la compra en cuestión
        if (count($itemCompra) == 0) { //Si el producto no fue cargado antes...
            $datosCI['cicantidad'] = 1; //Lo carga con  cantidad=1
            $objCompraItem->alta($datosCI); //da el alta a compraitem
        } else { //Si el producto fue cargado antes
            if ($itemCompra[0]->getObjProducto()->getStock() > $itemCompra[0]->getCantidad()) {
                $datosCI['cicantidad'] = $itemCompra[0]->getCantidad() + 1; //A la cantidad que tenía se le suma uno
                $datosCI['idcompraitem'] = $itemCompra[0]->getId(); //Obtiene el id de compraitem
                $objCompraItem->modificacion($datosCI); //Modifica el compra item (actualiza la cantidad)
            }
        }
    }

    function crearCompra($idProducto)
    {
        $session = new Session();
        $objCompra = new AbmCompra();
        $objCompraEstado = new AbmCompraEstado();
        $datosCompra['idusuario'] = $session->getUsuario()->getId(); //Obtiene el id del usuario 
        $datosCompra['cofecha'] = date("Y-m-d H:i:s");
        $objCompra->alta($datosCompra);
        // Creacion de obj CompraEstado
        // busco al obj compra para obtener el idcompra
        $compra = $objCompra->buscar($datosCompra)[0];
        $idCompra = $compra->getId();
        $datosCE['idcompra'] = $idCompra;
        $datosCE['cefechaini'] = date("Y-m-d H:i:s");
        $datosCE['cefechafin'] = "null";
        $datosCE['idcompraestadotipo'] = 1; //Se define que el alta de la compra inicializara en estado=1 (en el carrito)
        $objCompraEstado->alta($datosCE); //Se da el alta de la nueva compra
        $this->cargarProducto($datosCE['idcompra'], $idProducto); //Se invoca la funcion cargarProducto
    }
}// fin clase AbmCmpra
