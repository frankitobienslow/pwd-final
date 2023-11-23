<?php
include_once '../../configuracion.php';

$datos=data_submitted();
$objSession=new Session();
// desde el ajax llega un array asociativo indexado 
// ver como pasar de un JSON a un array asociativo PHP
// probar cuando envio los datos por ajax a esta pagina poner idusuario:<?php echo($objSession->getUsuario()->getId());
// => id y  cantidad);
$idUsuario=$objSession->getUsuario()->getId();
//    var_dump($datos['enviarCantidades'][$i]['id']);
    
    //var_dump($datos['enviarCantidades'][$i]['cantidad']); 
//var_dump($datos['enviarCantidades'][2]['id']);
//echo(count($datos['enviarCantidades'])." id: ".$idUsuario);

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

for($i=0;$i<$cantProductos;$i++){
    $datosCI['idproducto']=$datos['enviarCantidades'][$i]['id'];
    $datosCI['cicantidad']=$datos['enviarCantidades'][$i]['cantidad'];
    $objCompraItem->alta($datosCI);
}// fin 



?>
