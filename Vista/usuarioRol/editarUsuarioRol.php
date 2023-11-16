<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/headPrivado.php';
$data=data_submitted();
$objUsuarioRol = new AbmUsuarioRol();
if (isset($data['idusuario']) && $data['idrol']){
    $respuesta = $objUsuarioRol->baja($data);
    
    if (!$respuesta){

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
        
    }else $respuesta =true;
    
}
if($respuesta){
    echo "se elimino correctamente";
}else{
    echo "no se elimino";
}
/**$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
*/
?>