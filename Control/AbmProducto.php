<?php

class AbmProducto
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
     * @return Producto
     */
    private function cargarObjeto($datos)
    {
        $obj = null;

        if (
            array_key_exists('idproducto', $datos) && array_key_exists('pronombre', $datos)
            && array_key_exists('prodetalle', $datos) && array_key_exists('procantstock', $datos) && array_key_exists('proprecio', $datos) && array_key_exists('imagen', $datos) && array_key_exists('habilitado', $datos)
        ) {

            $obj = new Producto();
            $obj->setear($datos['idproducto'], $datos['pronombre'], $datos['prodetalle'], $datos['procantstock'], $datos['proprecio'], $datos['imagen'], $datos["habilitado"]);
        } // fin if 
        return $obj;
    } // fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Producto
     */
    private function cargarObjetoConClave($datos)
    {
        $obj = null;
        if (isset($datos['idproducto'])) {
            $obj = new Producto();
            $obj->setear($datos['idproducto'], $datos['pronombre'], $datos['prodetalle'], $datos['procantstock'], $datos['proprecio'], $datos['imagen'], $datos["habilitado"]);
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
        if (isset($datos['idproducto'], $datos['pronombre'], $datos['prodetalle'], $datos['procantstock'], $datos['proprecio'], $datos['imagen'], $datos["habilitado"])) {
            $resp = true;
        } // fin if 

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
        $datos['idproducto'] = null;
        $objProducto = $this->cargarObjeto($datos);
        //var_dump($datos);
        if ($objProducto != null && $objProducto->insertar()) {
            $resp = true;
        } // fin if 
        return $resp;
    } // fin function 


    /**
     * METDO ELIMINAR
     * @param array $datos
     * @return boolean
     */
    public function baja($datos)
    {
        $resp = false;
        if ($this->setadosCamposClaves($datos)) {
            $objProducto = $this->cargarObjetoConClave($datos);
            if ($objProducto != null && $objProducto->eliminar()) {
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
            $objProducto = $this->cargarObjeto($datos);
            var_dump($datos);
            if ($objProducto != null && $objProducto->modificar()) {
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
        $objProducto = new Producto();
        $where = " true ";
        if ($param <> null) {
            // Va preguntando si existe los campos de la tabla 
            if (isset($param['idproducto'])) {
                $where .= " and idproducto = " . $param['idproducto'];
            } // fin if 
            if (isset($param['pronombre'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and pronombre ='" . $param['pronombre'] . "'";
            } // fin if 
            if (isset($param['prodetalle'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            } // fin if 
            if (isset($param['procantstock'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and procantstock =" . $param['procantstock'];
            } // fin if 
            if (isset($param['proprecio'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and proprecio =" . $param['proprecio'] . "";
            } // fin if 
            if (isset($param['imagen'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and imagen ='" . $param['imagen'] . "'";
            } // fin if 
            if (isset($param['habilitado'])) { // identifica si esta la clave (atributo de la tabla)
                $where .= " and habilitado =" . $param['habilitado'];
            } // fin if 
        } // fin if
        $arreglo = $objProducto->listar($where);
        //var_dump($where); 
        return $arreglo;
    } // fin funcion     

    function eliminarProducto($idProducto)
    {
        $param["idproducto"] = $idProducto;
        $producto = $this->buscar($param)[0];
        $param["proprecio"] = $producto->getPrecio();
        $param["pronombre"] = $producto->getNombre();
        $param["prodetalle"] = $producto->getDetalle();
        $param["procantstock"] = $producto->getStock();
        $param["imagen"] = $producto->getImagen();
        $param["habilitado"] = 0;
        if ($this->modificacion($param)) {
            ob_clean();
            echo true;
        } else {
            echo "error";
        };
    }

    public function eliminar($datos)
    {
        $abmCompraEstado = new AbmCompraEstado;
        $abmCompraItem = new AbmCompraItem;

        $param["idproducto"] = $datos["eliminar"]; //Obtenemos el id del producto a eliminar
        $arregloCI = $abmCompraItem->buscar($param); //Buscamos los compraitem que tengan ese idproducto
        if (count($arregloCI) != 0) { //Si tiene compraitems asociados...
            $arregloCompras = [];
            foreach ($arregloCI as $compraItem) {
                // Obtenemos el ID de la compra asociada a este CompraItem
                $id = $compraItem->getObjCompra()->getId();
                // Verificamos si ya hemos agregado esta compra al arreglo (porque varios compraitem pueden tener el mismo idcompra)
                if (!isset($arregloCompras[$id])) {
                    // Si no, la agregamos al arreglo de compras
                    $arregloCompras[$id] = $compraItem->getObjCompra()->getId();
                }
            }
            $arregloCompras = array_values($arregloCompras); //Transformamos el $arregloCompras en un arreglo que almacena los id de las compras
            $arregloCE = [];
            $param["cefechafin"] = "null";
            for ($i = 0; $i < count($arregloCompras); $i++) { //Para cada compra, almacenamos el ultimo compraestado con ese idcompra
                $param["idcompra"] = $arregloCompras[$i];
                $CE = $abmCompraEstado->buscar($param)[0];
                if ($CE != null) {
                    $estadotipo = $CE->getObjCompraEstadoTipo()->getId();
                    if ($estadotipo == 1 || $estadotipo == 2 || $estadotipo == 6) {
                        array_push($arregloCE, $abmCompraEstado->buscar($param)[0]);
                    }
                }
            }
            $jsonCompras = [];
            for ($i = 0; $i < count($arregloCE); $i++) { //Se prepara la salida json
                $jsonCompras[$i]["idcompra"] = $arregloCE[$i]->getObjCompra()->getId();
                $jsonCompras[$i]["compraestadotipo"] = $arregloCE[$i]->getObjCompraEstadoTipo()->getDescripcion();
                $jsonCompras[$i]["cefechaini"] = $arregloCE[$i]->getFechaInicio();
                $jsonCompras[$i]["idcompraestado"] = $arregloCE[$i]->getId();
            }
            if ($jsonCompras != []) {
                ob_clean();
                echo json_encode($jsonCompras);
            } else {
                $this->eliminarProducto($datos["eliminar"]);
                ob_clean();
                echo 1;
            }
        } else {
            //Si no tienen itemcompras asociados
            $this->eliminarProducto($datos["eliminar"]);
        }
    }

    public function deshabilitar($datos)
    {
        $abmCompraEstado = new AbmCompraEstado;
        $abmCompraItem = new AbmCompraItem;
        $mailSender = new MailSender;
        $abmCompra = new AbmCompra;

        $arregloCompras = $datos["comprasAsociadas"]; //<--arreglo de los ultimos compra estado (1 o 2) que incluyan al producto
        $i = 0;
        foreach ($arregloCompras as $compraEstado) { //Para cada compra asociada
            $k = 0;
            $param["idcompraestado"] = $compraEstado["idcompraestado"];
            $CE = $abmCompraEstado->buscar(["idcompraestado" => $compraEstado["idcompraestado"]])[0];
            if ($CE != null) {
                $param["idcompra"] = $CE->getObjCompra()->getId();
                $compraItem = $abmCompraItem->buscar(["idcompra" => $param["idcompra"], "idproducto" => $datos["productoEliminar"]])[0]; //Se obtiene el compraitem correspondiente al producto a deshabilitar
                if ($compraItem != null) {
                    $abmCompraItem->modificacion(["idcompra" => $param["idcompra"], "idproducto" => $datos["productoEliminar"], "idcompraitem" => $compraItem->getId(), "cicantidad" => 0]); //Se le da cicantidad=0
                }
                $compraItems = $abmCompraItem->buscar(["idcompra" => $param["idcompra"]]); //Se itera entre todos los compraitem de esa compra
                foreach ($compraItems as $compraItem) {
                    if ($compraItem->getCantidad() == 0) { //se suma uno a $k si ese compraitem tiene cantidad=0
                        $k += 1;
                    }
                }
                if ($k == count($compraItems)) { //Si todos tienen cantidad=0, se cancela la compra
                    $estadotipo = 5;
                } else {
                    $estadotipo = 6; //Si no, se deja en "Pendiente" para que el usuario decida si a pesar de haberle cancelado productos quiere seguir con la compra
                };
                $param["idcompraestado"] = $CE->getId();
                $param["idcompraestadotipo"] = $CE->getObjCompraEstadoTipo()->getId();
                $param["cefechaini"] = $CE->getFechaInicio();
                $param["cefechafin"] = date("Y-m-d H:i:s");
                if ($abmCompraEstado->modificacion($param)) {
                    if ($param["idcompraestadotipo"] != 1) {
                        if ($abmCompraEstado->alta(["idcompra" => $CE->getObjCompra()->getId(), "idcompraestadotipo" => $estadotipo, "cefechaini" => date("Y-m-d H:i:s"), "cefechafin" => "null"])) {
                            $mailSender->sendEstado($abmCompra->buscar(["idcompra" => $CE->getObjCompra()->getId()])[0]);
                            ob_clean();
                        }
                    }
                    $i += 1;
                }
            }
        }
        if ($i == count($arregloCompras)) {
            $this->eliminarProducto($datos["productoEliminar"]);
        } else {
            echo "Error";
        }
    }

    public function habilitar($datos)
    {
        $param["idproducto"] = $datos["habilitar"];
        $producto = $this->buscar($param)[0];
        $param["proprecio"] = $producto->getPrecio();
        $param["pronombre"] = $producto->getNombre();
        $param["prodetalle"] = $producto->getDetalle();
        $param["procantstock"] = $producto->getStock();
        $param["imagen"] = $producto->getImagen();
        $param["habilitado"] = 1;
        if ($this->modificacion($param)) {
            ob_clean();
            echo true;
        } else {
            echo "error";
        };
    }

    public function editar($datos)
    {
        $imagenOK = false;
        if ($datos["pronombre"] != '' && $datos["prodetalle"] != '' && $datos["procantstock"] != '' && $datos["proprecio"] != '') {
            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
                $nombreArchivo = uniqid() . '_' . $_FILES['imagen']['name'];
                $carpetaDestino = "../imagenes/";
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino . $nombreArchivo)) {
                    $imagenOK = true;
                    $datos["imagen"] = $carpetaDestino . $nombreArchivo;
                }
            }
            if ($datos["idproducto"] != "nuevo") {
                if (!$imagenOK) {
                    $param["idproducto"] = $datos["idproducto"];
                    $datos["imagen"] = $this->buscar($param)[0]->getImagen();
                }
                $datos["habilitado"] = $this->buscar($param)[0]->getHabilitado();
                if ($this->modificacion($datos)) {
                    ob_clean();
                    echo "Producto modificado con éxito.";
                } else {
                    ob_clean();
                    echo "Hubo un error al efectuar la modificación.";
                }
            } else {

                if (!$imagenOK) {
                    $datos["imagen"] = "../imagenes/noimagen.jpg";
                }
                $datos["habilitado"] = 1;
                $this->alta($datos);
            }
        } else {
            echo "error";
        }
    }
} // fin clase 
