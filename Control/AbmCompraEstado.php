<?php

class AbmCompraEstado
{


    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompraEstado($datos)
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
     * @return CompraEstado
     */
    private function cargarObjeto($datos)
    {
        $obj = null;
        //var_dump($datos);
        if (
            array_key_exists('idcompraestado', $datos) && array_key_exists('idcompra', $datos)
            && array_key_exists('idcompraestadotipo', $datos) && array_key_exists('cefechaini', $datos)
            && array_key_exists('cefechafin', $datos)
        ) {
            //echo("entro al cargar obj");    
            // creo al obj compra
            $objC = new Compra();
            $objC->setId($datos['idcompra']);
            $objC->cargar();

            // creo el obj compraestadotipo
            $thisT = new CompraEstadoTipo();
            $thisT->setId($datos['idcompraestadotipo']);
            $thisT->cargar();

            // creo al obj compra 
            $obj = new CompraEstado();
            $obj->setear($datos['idcompraestado'], $objC, $thisT, $datos['cefechaini'], $datos['cefechafin']);
        } // fin if 

        return $obj;
    } // fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return CompraEstado
     */
    private function cargarObjetoConClave($datos)
    {
        $obj = null;
        if (isset($datos['idcompraestado'])) {
            // creo al obj compra
            $objC = new Compra();
            $objC->setId($datos['idusuario']);
            $objC->cargar();

            // creo al obj compraestadotipo
            $thisT = new CompraEstadoTipo();
            $thisT->setId($datos['idcompraestadotipo']);
            $thisT->cargar();

            // creo al obj compraEstado
            $obj = new CompraEstado();
            $obj->setear($datos['idcompraestado'], $objC, $thisT, $datos['cefechaini'], $datos['cefechafin']);
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

        //var_dump(isset($datos['cefechafin'])); // OJO!!!! isset si la variable es null, dará falso 
        if (
            array_key_exists('idcompraestado', $datos) && array_key_exists('idcompraestadotipo', $datos)
            && array_key_exists('idcompra', $datos) && array_key_exists('cefechaini', $datos) && isset($datos["cefechafin"])
        ) {
            $resp = true;
        }

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
        //var_dump($datos['cefechafin']);
        $datos['idcompraestado'] = null;
        //var_dump(array_key_exists('cefechafin',$datos));
        $objCompraEstado = $this->cargarObjeto($datos);

        if ($objCompraEstado != null && $objCompraEstado->insertar()) {
            $resp = true;
        } // fin if 
        //var_dump($resp);
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
        if ($this->setadosCamposClaves($datos)) {
            $objCompraEstado = $this->cargarObjetoConClave($datos);
            if ($objCompraEstado != null && $objCompraEstado->eliminar()) {
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
        var_dump($datos);
        if ($this->setadosCamposClaves($datos)) {
            $objCompraEstado = $this->cargarObjeto($datos);

            if ($objCompraEstado != null && $objCompraEstado->modificar()) {
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
        $objCompraEstado = new CompraEstado();
        $where = " true ";
        if ($param <> null) {
            // Va preguntando si existe los campos de la tabla 
            if (isset($param['idcompraestado'])) {
                $where .= " and idcompraestado=" . $param['idcompraestado'];
            } // fin if 
            if (isset($param['idcompra'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and idcompra =" . $param['idcompra'];
            } // fin if 
            if (isset($param['idcompraestadotipo'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
            } // fin if 
            if (isset($param['cefechaini'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and cefechaini ='" . $param['cefechaini'] . "'";
            } // fin if 
            if (isset($param["cefechafin"])) {
                if ($param['cefechafin'] === "null") {
                    $where .= " and cefechafin IS NULL";
                } else {
                    $where .= " and cefechafin = '" . $param['cefechafin'] . "'";
                }
            }
        } // fin if
        $arreglo = $objCompraEstado->listar($where);
        //var_dump($where); 
        return $arreglo;
    } // fin funcion     

    function cancelar($idcompraitem)
    {
        $datoCI["idcompraitem"] = $idcompraitem;
        $objP = new AbmProducto();
        $objCI = new AbmCompraItem();
        $unItem = $objCI->buscar($datoCI);
        $datoCI['idproducto'] = $unItem[0]->getObjProducto()->getId();
        $datoCI['idcompra'] = $unItem[0]->getObjCompra()->getId();
        $datosP['idproducto'] = $datoCI['idproducto'];
        $unProducto = $objP->buscar($datosP); // encuentra el obj con el id producto
        $stockNuevo = $unItem[0]->getCantidad() + $unProducto[0]->getStock(); // devuelve el stock al producto
        $datosP['idproducto'] = $unProducto[0]->getId();
        $datosP['procantstock'] = $stockNuevo;
        $datosP["proprecio"] = $unProducto[0]->getPrecio();
        $datosP['pronombre'] = $unProducto[0]->getNombre();
        $datosP['prodetalle'] = $unProducto[0]->getDetalle();
        $datosP['imagen'] = $unProducto[0]->getImagen();
        $datosP['habilitado'] = $unProducto[0]->getHabilitado();
        $datoCI['cicantidad'] = 0;
        $respCI = $objCI->modificacion($datoCI);
        $respP = $objP->modificacion($datosP);
    }

    public function procesarVenta($datos)
    {
        $arregloCancelar = json_decode($datos["procesarVenta"]);
        $mailSender = new MailSender;
        $objCI = new AbmCompraItem;
        $objCompra = new AbmCompra;
        $resp = "Compra enviada";
        $estadotipo = 3;
        if (count($arregloCancelar) > 0) { //Si se cancelaron productos
            foreach ($arregloCancelar as $idItem) {
                $this->cancelar($idItem); //Cancelar los productos
            }
            $compraItems = $objCI->buscar(["idcompra" => $datos["idcompra"]]); //Una vez cancelados, obtener los compraitems de esa compra
            $i = 0;
            foreach ($compraItems as $compraItem) {
                if ($compraItem->getCantidad() == 0) { //Se verifica si estan cancelados
                    $i++;
                }
            }
            if ($i == count($compraItems)) { //Si todos los compraitems estan cancelados, se cancela la compra
                $estadotipo = 5;
                $resp = "Compra cancelada.";
            } else {
                $estadotipo = 6; //Si no todos estan cancelados, queda pendiente.
            }
        }
        $datosCE["idcompra"] = json_decode($datos["idcompra"]);
        $datosCE["cefechafin"] = "null";
        $compraEstado = $this->buscar($datosCE)[0];
        $datosCE["idcompraestado"] = $compraEstado->getId();
        $datosCE["idcompraestadotipo"] = 2;
        $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
        $datosCE["cefechafin"] = date("Y-m-d H:i:s");
        $this->modificacion($datosCE); //Modifica la fecha fin del estado 2 de la compra
        $datosCE['idcompraestadotipo'] = $estadotipo;
        $datosCE['cefechaini'] = $datosCE['cefechafin'];
        $datosCE['cefechafin'] = "null";
        $this->alta($datosCE); //Crea el nuevo estado de la compra
        $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
        ob_clean();
        echo $resp;
    }
    public function entregarVenta($datos)
    {
        $mailSender = new MailSender;
        $objCompra = new AbmCompra;
        $datosCE["idcompra"] = json_decode($datos["idcompraEnviar"]);
        $datosCE["cefechafin"] = "null";
        $compraEstado = $this->buscar($datosCE)[0];
        $datosCE["idcompraestado"] = $compraEstado->getId();
        $datosCE["idcompraestadotipo"] = 3;
        $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
        $datosCE["cefechafin"] = date("Y-m-d H:i:s");
        $this->modificacion($datosCE); //Modifica la fecha fin del estado 3 de la compra
        $datosCE['idcompraestadotipo'] = 4;
        $datosCE['cefechaini'] = $datosCE['cefechafin'];
        $datosCE['cefechafin'] = "null";
        $this->alta($datosCE); //Crea el nuevo estado de la compra
        $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
        ob_clean();
        echo "La compra ID:" . $datos["idcompraEnviar"] . " fue entregada.";
    }

    public function cancelarCompra($datos)
    {
        $mailSender = new MailSender;
        $objCompra = new AbmCompra;
        $param["idcompra"] = $datos["cancelarCompra"];
        $datosCE["idcompra"] = $param["idcompra"];
        $datosCE["cefechafin"] = "null";
        $compraEstado = $this->buscar($datosCE)[0];
        $datosCE["idcompraestado"] = $compraEstado->getId();
        $datosCE["idcompraestadotipo"] = 6;
        $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
        $datosCE["cefechafin"] = date("Y-m-d H:i:s");
        $this->modificacion($datosCE); //Modifica la fecha fin del estado 6 de la compra
        $datosCE['idcompraestadotipo'] = 5;
        $datosCE['cefechaini'] = $datosCE['cefechafin'];
        $datosCE['cefechafin'] = "null";
        $this->alta($datosCE); //Crea el nuevo estado de la compra CANCELADO
        $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
        ob_clean();
        echo "Se canceló la compra";
    }

    public function aceptarCompra($datos)
    {
        $mailSender = new MailSender;
        $objCompra = new AbmCompra;
        $param["idcompra"] = $datos["aceptarCompra"];
        $datosCE["idcompra"] = $param["idcompra"];
        $datosCE["cefechafin"] = "null";
        $compraEstado = $this->buscar($datosCE)[0];
        $datosCE["idcompraestado"] = $compraEstado->getId();
        $datosCE["idcompraestadotipo"] = 6;
        $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
        $datosCE["cefechafin"] = date("Y-m-d H:i:s");
        $this->modificacion($datosCE); //Modifica la fecha fin del estado 6 de la compra
        $datosCE['idcompraestadotipo'] = 2;
        $datosCE['cefechaini'] = $datosCE['cefechafin'];
        $datosCE['cefechafin'] = "null";
        $this->alta($datosCE); //Crea el nuevo estado de la compra EN PROCESO
        $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
        ob_clean();
        echo "Se continuará la compra";
    }

    function obtenerCarrito()
    {
        $session = new Session();
        $objCompra = new AbmCompra();
        $datosCE["idusuario"] = $session->getUsuario()->getId(); //Obtiene el id del usuario  
        $comprasDelUsuario = $objCompra->buscar($datosCE);    //Busca las compras que hizo el usuario
        $cantCompras = count($comprasDelUsuario); //Obtiene la cantidad de esas compras
        for ($i = 0; $i < $cantCompras; $i++) {
            $param["idcompra"] = $comprasDelUsuario[$i]->getId();
            $param["idcompraestadotipo"] = 1;
            $param["cefechafin"] = "null";
            $compraEncontrada = $this->buscar($param);
            if (count($compraEncontrada) != 0) {
                $datosCE["idcompra"] = $param["idcompra"];
            }
        }
        return $datosCE;
    }

    public function getCarrito($datos)
    {
        $datosCE = $this->obtenerCarrito();
        $objCompraItem = new AbmCompraItem;
        if (isset($datosCE["idcompra"])) {
            $datosCI["idcompra"] = $datosCE["idcompra"]; //El id de compraItem es el mismo que el id de la compra con estado 1
            $arregloProductos = $objCompraItem->buscar($datosCI); //Se traen todos los compraitem de esa compra
            foreach ($arregloProductos as $producto) { //Se recorre el arreglo de compraitems
                $objProducto = $producto->getObjProducto();
                $retorno['productos'][] = [ //Se genera un arreglo asociativo con los datos de los productos
                    'nombre' => $objProducto->getNombre(),
                    'detalle' => $objProducto->getDetalle(),
                    'precio' => $objProducto->getPrecio(),
                    'id' => $objProducto->getId(),
                    'stock' => $objProducto->getStock(),
                    'cantidad' => $producto->getCantidad(),
                    'imagen' => $objProducto->getImagen()
                ];
            }
            header('Content-Type: application/json');
            ob_end_clean();
            echo json_encode($retorno); //Se envía a carrito.js para que los renderice
        }
    }
    public function eliminarItemsCarrito($datos)
    {
        $datosCE = $this->obtenerCarrito();
        $objCompraItem = new AbmCompraItem;
        $datosCI["idcompra"] = $datosCE["idcompra"]; //El id de compraItem es el mismo que el id de la compra con estado 1
        $arregloProductos = $objCompraItem->buscar($datosCI); //Se traen todos los compraitem de esa compra
        $eliminado = false;
        foreach ($arregloProductos as $producto) { //Se recorre el arreglo de compraitems
            $objProducto = $producto->getObjProducto();
            if ($objProducto->getId() == $datos["idEliminar"]) { //Si se encuentra el producto a eliminar...
                $eliminado = $objCompraItem->baja(["idcompraitem" => $producto->getId(), "idproducto" => $objProducto->getId(), "idcompra" => $datosCE["idcompra"], "cicantidad" => $producto->getCantidad()]);
                if (count($arregloProductos) == 1) { //Si era el ultimo producto de la compra...
                    $datosCE["idcompraestadotipo"] = 1;
                    $datosCE["idcompraestado"] = $this->buscar($datosCE)[0]->getId();
                    $datosCE["cefechaini"] = $this->buscar($datosCE)[0]->getFechaInicio();
                    $datosCE["cefechafin"] = date("Y-m-d H:i:s");
                    if ($this->modificacion($datosCE)) {
                        ob_clean();
                        echo "El carrito está vacío.";
                    }
                }
            }
            if ($eliminado) {
                break;
            }
        }
    }

    public function confirmarCompra($datos)
    {
        $mailSender = new MailSender;
        $objCompraItem = new AbmCompraItem;
        $objCompra = new AbmCompra;
        //Actualiza las cantidades de acuerdo al valor de los input de cantidades
        $error = false;
        $datosCI["idcompra"] = $this->obtenerCarrito()["idcompra"];
        $arregloCantidades = $datos["confirmarCompra"];
        $arregloCI = $objCompraItem->buscar($datosCI);
        $objProducto = new AbmProducto();
        foreach ($arregloCI as $itemCompra) {
            $datosP["habilitado"] = $itemCompra->getObjProducto()->getHabilitado();
            if ($datosP["habilitado"] != 0) {
                foreach ($arregloCantidades as $producto) {
                    if ($itemCompra->getObjProducto()->getId() == $producto["idproducto"]) {
                        $stockProducto = $objProducto->buscar($producto)[0]->getStock();
                        if ($producto["cicantidad"] <= $stockProducto) {
                            $datosCI["idproducto"] = $producto["idproducto"];
                            $datosCI["cicantidad"] = $producto["cicantidad"];
                            $datosCI["idcompraitem"] = $itemCompra->getId();
                            $objCompraItem->modificacion($datosCI); //Actualiza las cantidades de compraitem segun el valor de los input de cantidades
                            $datosP["idproducto"] = $datosCI["idproducto"];
                            $datosP["proprecio"] = $itemCompra->getObjProducto()->getPrecio();
                            $datosP["pronombre"] = $itemCompra->getObjProducto()->getNombre();
                            $datosP["prodetalle"] = $itemCompra->getObjProducto()->getDetalle();
                            $datosP["procantstock"] = $itemCompra->getObjProducto()->getStock() - $datosCI["cicantidad"];
                            $datosP["imagen"] = $itemCompra->getObjProducto()->getImagen();
                            $objProducto->modificacion($datosP); //Actualiza el stock del producto
                        } else {
                            $error = true;
                        }
                    }
                }
            } else {
                $error = true;
            }
        }
        if (!$error) {
            $datosCE["idcompra"] = $datosCI["idcompra"];
            $datosCE["cefechafin"] = "null";
            $compraEstado = $this->buscar($datosCE)[0];
            $datosCE["idcompraestado"] = $compraEstado->getId();
            $datosCE["idcompraestadotipo"] = 1;
            $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
            $datosCE["cefechafin"] = date("Y-m-d H:i:s");
            $this->modificacion($datosCE); //Modifica la fecha fin del estado 1 de la compra
            $datosCE['idcompraestadotipo'] = 2;
            $datosCE['cefechaini'] = $datosCE['cefechafin'];
            $datosCE['cefechafin'] = "null";
            $this->alta($datosCE); //Crea el nuevo estado de la compra
            $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
            ob_clean();
            echo "Su compra se ha realizado con éxito. Haga el seguimiento desde Mis Compras.";
        } else {
            ob_clean();
            echo "Se produjo un error al procesar la compra, no contamos con stock para los productos solicitados.";
        }
    }
} // fin clase 
