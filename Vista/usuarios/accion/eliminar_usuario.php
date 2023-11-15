<?php
include_once "../../../configuracion.php";
//$data = data_submitted();
$data["idusuario"]=1;
$id["idusuario"]=$data["idusuario"];
if (isset($data['idusuario'])){
    $objC = new AbmUsuario();
    $usuario=$objC->buscar($id);
    var_dump($usuario);
    $data["usnombre"]=$usuario[0]->getNombre();
    $data["usmail"]=$usuario[0]->getMail();
    $data["usdeshabilitado"]="CURRENT_TIMESTAMP";
    $respuesta = $objC->modificacion($data);
    if (!$respuesta){
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>