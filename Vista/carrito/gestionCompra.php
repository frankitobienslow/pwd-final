<?php
include_once '../../configuracion.php';

$datos=data_submitted();
$objSession=new Session();
// desde el ajax llega un array asociativo indexado 
// ver como pasar de un JSON a un array asociativo PHP
// probar cuando envio los datos por ajax a esta pagina poner idusuario:<?php echo($objSession->getUsuario()->getId());
// => id y  cantidad);

if(isset($datos['vaciar'])&& $datos['vaciar']=='si'){
    $objSession->vaciarCarrito();
}

$idUsuario=$objSession->getUsuario()->getId();

// Creacion de obj Compra 
$objCompra=new AbmCompra();
$datosCompra['idusuario']=$idUsuario;
$datosCompra['cofecha']=date("Y-m-d H:i:s");
$objCompra->alta($datosCompra);

// Creacion de obj CompraEstado
$objCompraEstado=new AbmCompraEstado();
// busco al obj compra para obtener el idcompra
$compra=$objCompra->buscar($datosCompra)[0];
$idCompra=$compra->getId();
$datosCE['idcompra']=$idCompra;
$datosCE['idcompraestadotipo']=2;
$datosCE['cefechaini']=date("Y-m-d H:i:s");
$datosCE['cefechafin']=null;

$objCompraEstado->alta($datosCE);

// Creacion de obj compraItem
$objCompraItem=new AbmCompraItem();
$cantProductos =count($datos['enviarCantidades']);
$datosCI['idcompra']=$idCompra;

// crear el abm producto buscarlo con el id y llamadar al modificacion 
$objProducto=new AbmProducto();


//var_dump($cantProductos);
for($i=0;$i<$cantProductos;$i++){
    $datosCI['idproducto']=$datos['enviarCantidades'][$i]['id'];
    $datosCI['cicantidad']=$datos['enviarCantidades'][$i]['cantidad'];
    $objCompraItem->alta($datosCI);
    $datoP['idproducto']=$datos['enviarCantidades'][$i]['id'];
    $objUnItem=$objCompraItem->buscar($datoP); // obtengo el obj producto desde compra item
    $unProducto=$objUnItem[0]->getObjProducto();
    $nuevoStock=$unProducto->getStock()-$datosCI['cicantidad'];
    $datoP['pronombre']=$unProducto->getNombre();
    $datoP['prodetalle']=$unProducto->getDetalle();
    $datoP['procantstock']=$nuevoStock;
    $objProducto->modificacion($datoP);

}// fin 
//echo("Stock: ".$datoP['procantstock']." Nombre: ".$datoP['pronombre']);
?>
