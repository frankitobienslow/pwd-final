<?php
include_once '../../configuracion.php';
include_once '../mails/accionMails.php';

$datos = data_submitted();
$objCE = new AbmCompraEstado();
$objSession = new Session();
$objCI = new AbmCompraItem();
$mailSender = new MailSender;
$objCompra=new AbmCompra();


if (isset($datos["procesarVenta"])) {
    $arregloCancelar = json_decode($datos["procesarVenta"]);
    $resp = "Compra enviada";
    $estadotipo = 3;
    if (count($arregloCancelar) > 0) {//Si se cancelaron productos
        foreach ($arregloCancelar as $idItem) {
            cancelar($idItem);//Cancelar los productos
        }
        $compraItems = $objCI->buscar(["idcompra" => $datos["idcompra"]]);//Una vez cancelados, obtener los compraitems de esa compra
        $i = 0;
        foreach ($compraItems as $compraItem) {
            if ($compraItem->getCantidad() == 0) {//Se verifica si estan cancelados
                $i++;
            }
        }
        if ($i == count($compraItems)) {//Si todos los compraitems estan cancelados, se cancela la compra
            $estadotipo = 5;
            $resp="Compra cancelada.";
        }else{
            $estadotipo = 6; //Si no todos estan cancelados, queda pendiente.
        }
    }
    $datosCE["idcompra"] = json_decode($datos["idcompra"]);
    $datosCE["cefechafin"] = "null";
    $compraEstado = $objCE->buscar($datosCE)[0];
    $datosCE["idcompraestado"] = $compraEstado->getId();
    $datosCE["idcompraestadotipo"] = 2;
    $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
    $datosCE["cefechafin"] = date("Y-m-d H:i:s");
    $objCE->modificacion($datosCE); //Modifica la fecha fin del estado 2 de la compra
    $datosCE['idcompraestadotipo'] = $estadotipo;
    $datosCE['cefechaini'] = $datosCE['cefechafin'];
    $datosCE['cefechafin'] = "null";
    $objCE->alta($datosCE); //Crea el nuevo estado de la compra
    $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
    ob_clean();
    echo $resp;
}

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
    $datoCI['cicantidad'] = 0;
    $respCI = $objCI->modificacion($datoCI);
    $respP = $objP->modificacion($datosP);
}

//Logica entregar compra
if (isset($datos["idcompraEnviar"])) {
    $datosCE["idcompra"] = json_decode($datos["idcompraEnviar"]);
    $datosCE["cefechafin"] = "null";
    $compraEstado = $objCE->buscar($datosCE)[0];
    $datosCE["idcompraestado"] = $compraEstado->getId();
    $datosCE["idcompraestadotipo"] = 3;
    $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
    $datosCE["cefechafin"] = date("Y-m-d H:i:s");
    $objCE->modificacion($datosCE); //Modifica la fecha fin del estado 3 de la compra
    $datosCE['idcompraestadotipo'] = 4;
    $datosCE['cefechaini'] = $datosCE['cefechafin'];
    $datosCE['cefechafin'] = "null";
    $objCE->alta($datosCE); //Crea el nuevo estado de la compra
    $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
    ob_clean();
    echo "La compra ID:" . $datos["idcompraEnviar"] . " fue entregada.";
}

//Logica cancelar compra por el usuario (cuando esta en pendiente)
if (isset($datos["cancelarCompra"])) {
    $param["idcompra"] = $datos["cancelarCompra"];
    $cancelar = $objCE->buscar($param)[0];
    $datosCE["idcompra"] = $param["idcompra"];
    $datosCE["cefechafin"] = "null";
    $compraEstado = $objCE->buscar($datosCE)[0];
    $datosCE["idcompraestado"] = $compraEstado->getId();
    $datosCE["idcompraestadotipo"] = 6;
    $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
    $datosCE["cefechafin"] = date("Y-m-d H:i:s");
    $objCE->modificacion($datosCE); //Modifica la fecha fin del estado 6 de la compra
    $datosCE['idcompraestadotipo'] = 5;
    $datosCE['cefechaini'] = $datosCE['cefechafin'];
    $datosCE['cefechafin'] = "null";
    $objCE->alta($datosCE); //Crea el nuevo estado de la compra CANCELADO
    $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
    ob_clean();
    echo "Se canceló la compra";
}

//Logica aceptar compra por el usuario (cuando esta en pendiente)
if (isset($datos["aceptarCompra"])) {
    $param["idcompra"] = $datos["aceptarCompra"];
    $cancelar = $objCE->buscar($param)[0];
    $datosCE["idcompra"] = $param["idcompra"];
    $datosCE["cefechafin"] = "null";
    $compraEstado = $objCE->buscar($datosCE)[0];
    $datosCE["idcompraestado"] = $compraEstado->getId();
    $datosCE["idcompraestadotipo"] = 6;
    $datosCE["cefechaini"] = $compraEstado->getFechaInicio();
    $datosCE["cefechafin"] = date("Y-m-d H:i:s");
    $objCE->modificacion($datosCE); //Modifica la fecha fin del estado 6 de la compra
    $datosCE['idcompraestadotipo'] = 2;
    $datosCE['cefechaini'] = $datosCE['cefechafin'];
    $datosCE['cefechafin'] = "null";
    $objCE->alta($datosCE); //Crea el nuevo estado de la compra EN PROCESO
    $mailSender->sendEstado($objCompra->buscar(["idcompra" => $datosCE["idcompra"]])[0]);
    ob_clean();
    echo "Se continuará la compra";
}
