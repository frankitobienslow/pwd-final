<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmUsuario();
$list = $objControl->buscar(null);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idusuario'] = $elem->getId();
    $nuevoElem["usnombre"]=$elem->getNombre();
    $nuevoElem["usdeshabilitado"]=$elem->getDeshabilitado();
    $nuevoElem["usmail"]=$elem->getMail();
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,null,2);

?>