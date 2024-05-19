<?php
include_once("../../configuracion.php");
include_once("../mails/accionMails.php");
$datos = $_POST;
$abmProducto = new AbmProducto;
$abmCompraItem = new AbmCompraItem;
$abmCompraEstado = new AbmCompraEstado;
$abmCompra = new AbmCompra;
$mailSender = new MailSender;

$imagenOK = false;

if (isset($datos["eliminar"])) { //Logica eliminar
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
            eliminarProducto($datos["eliminar"]);
            ob_clean();
            echo 1;
        }
    } else {
        //Si no tienen itemcompras asociados
        eliminarProducto($datos["eliminar"]);
    }
}

if (isset($datos["productoEliminar"])) { //Logica para deshabilitar un producto y cancelar las compras asociadas
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
        eliminarProducto($datos["productoEliminar"]);
    } else {
        echo "Error";
    }
}

//Logica editar/nuevo
if (isset($datos["idproducto"])) {
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
                $datos["imagen"] = $abmProducto->buscar($param)[0]->getImagen();
            }
            $datos["habilitado"] = $abmProducto->buscar($param)[0]->getHabilitado();
            if ($abmProducto->modificacion($datos)) {
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
            $abmProducto->alta($datos);
        }
    } else {
        echo "error";
    }
}

if (isset($datos["habilitar"])) {
    $param["idproducto"] = $datos["habilitar"];
    $producto = $abmProducto->buscar($param)[0];
    $param["proprecio"] = $producto->getPrecio();
    $param["pronombre"] = $producto->getNombre();
    $param["prodetalle"] = $producto->getDetalle();
    $param["procantstock"] = $producto->getStock();
    $param["imagen"] = $producto->getImagen();
    $param["habilitado"] = 1;
    if ($abmProducto->modificacion($param)) {
        ob_clean();
        echo true;
    } else {
        echo "error";
    };
}

function eliminarProducto($idProducto)
{
    $abmProducto = new AbmProducto;
    $param["idproducto"] = $idProducto;
    $producto = $abmProducto->buscar($param)[0];
    $param["proprecio"] = $producto->getPrecio();
    $param["pronombre"] = $producto->getNombre();
    $param["prodetalle"] = $producto->getDetalle();
    $param["procantstock"] = $producto->getStock();
    $param["imagen"] = $producto->getImagen();
    $param["habilitado"] = 0;
    if ($abmProducto->modificacion($param)) {
        ob_clean();
        echo true;
    } else {
        echo "error";
    };
}
