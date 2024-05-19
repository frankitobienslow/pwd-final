<?php
ob_start();
include_once("../../configuracion.php");
$datos = data_submitted();
$session = new Session();
$objAbmCompraEstado = new AbmCompraEstado;
$objAbmCompraItem = new AbmCompraItem;
$objAbmCompra = new AbmCompra;

if (isset($datos["accion"])) {
    $comprasUsuario = $objAbmCompra->buscar(["idusuario" => $session->getUsuario()->getId()]);
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

//Si se agregó un producto...
if (isset($datos["idAgregar"])) {
    $error = false;
    $objCompra = new AbmCompra();
    $objCompraEstado = new AbmCompraEstado();
    $objProducto = new AbmProducto();
    $objCompraItem = new AbmCompraItem;
    $datosP["idproducto"] = $datos["idAgregar"];
    $stockProducto = $objProducto->buscar($datosP)[0]->getStock();

    if ($stockProducto > 0) { //Si el producto seleccionado está en stock...
        $datosCE["idusuario"] = $session->getUsuario()->getId(); //Se obtiene el ID del usuario
        $comprasDelUsuario = $objCompra->buscar($datosCE);    //Busca las compras que hizo el usuario
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
            cargarProducto($datosCI['idcompra'], $datos["idAgregar"]); //Se invoca la funcion cargarProducto
            ob_clean();
            echo "Se agregó el producto.";
        } else if (!$error) { //Si el usuario no realizó compras
            crearCompra($datos["idAgregar"]); //Se crea una nueva compra con idcompraestadotipo=1
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
    cargarProducto($datosCE['idcompra'], $idProducto); //Se invoca la funcion cargarProducto
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
