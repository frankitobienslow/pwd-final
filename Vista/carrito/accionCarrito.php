<?php
include_once '../../configuracion.php';
include_once '../mails/accionMails.php';
$datos = data_submitted();
$objCompraItem = new AbmCompraItem();
$objCompraEstado = new AbmCompraEstado();
$session = new Session();
$objCompra = new AbmCompra();
$mailSender = new MailSender;

function obtenerCarrito()
{
    $objCompraEstado = new AbmCompraEstado();
    $session = new Session();
    $objCompra = new AbmCompra();
    $datosCE["idusuario"] = $session->getUsuario()->getId(); //Obtiene el id del usuario  
    $comprasDelUsuario = $objCompra->buscar($datosCE);    //Busca las compras que hizo el usuario
    $cantCompras = count($comprasDelUsuario); //Obtiene la cantidad de esas compras
    for ($i = 0; $i < $cantCompras; $i++) {
        $param["idcompra"] = $comprasDelUsuario[$i]->getId();
        $param["idcompraestadotipo"] = 1;
        $param["cefechafin"] = "null";
        $compraEncontrada = $objCompraEstado->buscar($param);
        if (count($compraEncontrada) != 0) {
            $datosCE["idcompra"] = $param["idcompra"];
        }
    }
    return $datosCE;
}

if (isset($datos["obtenerCarrito"])) {
    $datosCE = obtenerCarrito();
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

//Elimina el producto del carrito
if (isset($datos["idEliminar"])) {
    $datosCE = obtenerCarrito();
    $datosCI["idcompra"] = $datosCE["idcompra"]; //El id de compraItem es el mismo que el id de la compra con estado 1
    $arregloProductos = $objCompraItem->buscar($datosCI); //Se traen todos los compraitem de esa compra
    $eliminado = false;
    foreach ($arregloProductos as $producto) { //Se recorre el arreglo de compraitems
        $objProducto = $producto->getObjProducto();
        if ($objProducto->getId() == $datos["idEliminar"]) { //Si se encuentra el producto a eliminar...
            $eliminado = $objCompraItem->baja(["idcompraitem" => $producto->getId(), "idproducto" => $objProducto->getId(), "idcompra" => $datosCE["idcompra"], "cicantidad" => $producto->getCantidad()]);
            if (count($arregloProductos) == 1) { //Si era el ultimo producto de la compra...
                $datosCE["idcompraestadotipo"] = 1;
                $datosCE["idcompraestado"] = $objCompraEstado->buscar($datosCE)[0]->getId();
                $datosCE["cefechaini"] = $objCompraEstado->buscar($datosCE)[0]->getFechaInicio();
                $datosCE["cefechafin"] = date("Y-m-d H:i:s");
                if ($objCompraEstado->modificacion($datosCE)) {
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

if (isset($datos["confirmarCompra"])) {
    //Actualiza las cantidades de acuerdo al valor de los input de cantidades
    $error = false;
    $datosCI["idcompra"] = obtenerCarrito()["idcompra"];
    $arregloCantidades = $datos["confirmarCompra"];
    $arregloCI = $objCompraItem->buscar($datosCI);
    $objProducto = new AbmProducto();
    foreach ($arregloCI as $itemCompra) {
        $datosP["habilitado"] = $itemCompra->getObjProducto()->getHabilitado();
        if($datosP["habilitado"]!=0){
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
        }else{
            $error=true;
        }
        
    }
    if (!$error) {
        $datosCE["idcompra"] = $datosCI["idcompra"];
        $datosCE["cefechafin"] = "null";
        $compraEstado = $objCompraEstado->buscar($datosCE)[0];
        $datosCE["idcompraestado"] = $compraEstado->getId();
        $datosCE["idcompraestadotipo"] = 1;
        $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
        $datosCE["cefechafin"] = date("Y-m-d H:i:s");
        $objCompraEstado->modificacion($datosCE); //Modifica la fecha fin del estado 1 de la compra
        $datosCE['idcompraestadotipo'] = 2;
        $datosCE['cefechaini'] = $datosCE['cefechafin'];
        $datosCE['cefechafin'] = "null";
        $objCompraEstado->alta($datosCE); //Crea el nuevo estado de la compra
        $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
        ob_clean();
        echo "Su compra se ha realizado con éxito. Haga el seguimiento desde Mis Compras.";
    } else {
        ob_clean();
        echo "Se produjo un error al procesar la compra, no contamos con stock para los productos solicitados.";
    }
}
