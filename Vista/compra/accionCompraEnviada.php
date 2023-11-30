<?php
include_once '../../configuracion.php';

$datoCI=data_submitted();
$objCI=new AbmCompraItem();
$objP=new AbmProducto();
$objCE=new AbmCompraEstado();

//var_dump($datoCI);
//$listaItems=$objCI->buscar($datos);

if(isset($datoCI['idcompraitem'])){
    // obtengo el obj producto con el id Item 
    $datoCI['idcompraitem']=$datoCI['idcompraitem'];
    $unItem=$objCI->buscar($datoCI);
    //var_dump($unItem[0]->getObjProducto()->getId());
    //var_dump($unItem[0]); 
    $datoCI['idproducto']=$unItem[0]->getObjProducto()->getId();
    $datoCI['idcompra']=$unItem[0]->getObjCompra()->getId();
    //$datoCI['cicantidad']=$unItem[0]->getCantidad(); // se realiza un borrado logico del item de la compra
    //var_dump($respCI);
    // llenado de datos para cambiar el stock de producto
    $datosP['idproducto']=$datoCI['idproducto'];
    $unProducto=$objP->buscar($datosP); // encuentra el obj con el id producto
    //var_dump($unProducto[0]->getStock());
    $stockNuevo=$unItem[0]->getCantidad()+$unProducto[0]->getStock() ; // devuelve el stock al producto
    $datosP['idproducto']=$unProducto[0]->getId();
    $datosP['procantstock']=$stockNuevo;
   // var_dump($stockNuevo);
    $datosP['pronombre']=$unProducto[0]->getNombre();
    $datosP['prodetalle']=$unProducto[0]->getDetalle();
    $datoCI['cicantidad']=0;
    // Llamamos a los modificacion de compra item y producto
     $respCI=$objCI->modificacion($datoCI);
    
    $respP=$objP->modificacion($datosP);
    var_dump($respP);
    
    
}// fin if

if(isset($datos['idcompra'])){
    // busca el estado de compra con idcompra y cefechafin = null
    $datosCE['idcompra']=$datos['idcompra'];
    $datosCE['cefechafin']=null; 
    $ultimoCE=$objCE->buscar($datosCE);
    $datosCE['idcompraestadotipo']=2;
    $datosCE['cefechaini']=$ultimoCE[0]->getFechaInicio();
    $datosCE['cefechafin']=date("Y-m-d H:i:s"); // piso la fecha fin para despues crear el siguiente estado de la compra
    $datosCE['idcompraestado']=$ultimoCE[0]->getId();
    $respuestaM=$objCE->modificacion($datosCE); // cambia la fecha fin con un date dado
    
    // dar de alta al nuev estado compra 
    $datosCE['idcompraestadotipo']=3;
    $datosCE['cefechaini']=$datosCE['cefechafin'];
    $datosCE['cefechafin']=null;
    $respuestaA=$objCE->alta($datosCE); 
    var_dump($respuestaA);
}// fin if 


?>