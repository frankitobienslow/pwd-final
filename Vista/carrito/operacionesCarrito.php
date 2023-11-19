<?php
include_once '../../configuracion.php';

//Crea el objeto session
$objSession = new Session();

//Si se agregó un producto...
if (isset($_POST["idAgregar"])) {
    //Agrega el producto al carrito y retorna la cantidad de productos en el carrito
    echo $objSession->agregarAlCarrito($_POST["idAgregar"]);
}
//Elimina el producto al carrito y retorna la cantidad de productos en el carrito
if (isset($_POST["idEliminar"])) {
    echo $objSession->eliminarDelCarrito($_POST['idEliminar']);
}

if (isset($_POST["obtenerCarrito"])) {
    $arregloProductos = $objSession->getCarrito();
    foreach ($arregloProductos as $producto) {
        $retorno['productos'][] = [
            'nombre' => $producto->getNombre(),
            'detalle' => $producto->getDetalle(),
            'precio' => $producto->getPrecio(),
            'id' => $producto->getId(),
            'stock'=>$producto->getStock()
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($retorno);
}

//Si la llamada es para actualizar el ícono del carrito...
if (isset($_POST['actualizarIcono'])) {
    //Retorna la cantidad de productos en el carrito
    echo count($objSession->getCarrito());
}
