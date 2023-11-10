<?php
include_once '../configuracion.php';

//----------- prueba de alta y modificacion ------------------------------
// MENU 
/**  
$datos['idmenu']=1;
$datos['menombre']='adm';//date('Y-m-d H:i:s');
$datos['medescripcion']='../adm/test.php';
$datos['idpadre']=0;
$datos['medeshabilitado']=null;//date('Y-m-d H:i:s');
$objMenu=new AbmMenu();
$objMenu->modificacion($datos);
echo("<br>----Hecho----<br>");
*/

// USUARIO
/** 
$datos['idusuario']=1;
$datos['usnombre']='pepe';
$datos['uspass']=md5('123');
$datos['usmail']='p@gmail.com';
$datos['usdeshabilitado']=date('Y-m-d H:i:s');
$objUsuario=new AbmUsuario();
$objUsuario->modificacion($datos);
echo("<br>----Hecho usuario ----<br>");
*/

// ROL
/** 
$datos['idrol']=1;
$datos['rodescripcion']='administrador';
$objUsuario=new AbmRol();
$objUsuario->modificacion($datos);
echo("<br>----Hecho rol ----<br>");
*/

// COMPRA 
 /** 
$datos['idcompra']=5;
$datos['cofecha']=null;//date('Y-m-d H:i:s');
$datos['idusuario']=9;
$objCompra=new AbmCompra();   // NOTA:  LA FUNCION MODIFICAR DE COMPRA NO FUNCIONA PORQUE EL METODO SETAERCAMPOCLAVES DA FALSO
$objCompra->modificacion($datos);
echo("<br>----Hecho compra ----<br>");
*/

//PRODUCTO 
//$datos['idproducto']=1;
 /** 
$datos['pronombre']="jdjdhdd";//date('Y-m-d H:i:s');
$datos['prodetalle']="ksjsh";
$datos['procantstock']=999;
$objProducto=new AbmProducto();
$objProducto->alta($datos);
echo("<br>----Hecho producto ----<br>");
*/

// MENUROL
/** 
$datos['idrol']=1;//date('Y-m-d H:i:s');
$datos['idmenu']=2;
$objMenuRol=new AbmMenuRol();
$objMenuRol->modificacion($datos);  // NO SE USA LOS MOETODOS DE MODIFICACION EN LAS TABLAS CON ENTIDADES DEBILES MENUROL - USUARIOROL - 
echo("<br>----Hecho menurol ----<br>");
*/

// USUARIOROL
/** 
$datos['idrol']=1;//date('Y-m-d H:i:s');
$datos['idusuario']=1;
$objUserRol=new AbmUsuarioRol();
$objUserRol->alta($datos);  // NO SE USA LOS MOETODOS DE MODIFICACION EN LAS TABLAS CON ENTIDADES DEBILES MENUROL - USUARIOROL - 
echo("<br>----Hecho usuariorol ----<br>");
*/

// COMPRA ESTADO TIPO
/** 
$datos['idcompraestadotipo']=1;//date('Y-m-d H:i:s');
$datos['cetdescripcion']="muchas compras ";
$datos['cetdetalle']=" todo caro";
$objCompEst=new AbmCompraEstadoTipo();
$objCompEst->modificacion($datos);

echo("<br>----Hecho compraestadotipo ----<br>");
*/

// COMPRA ESTADO 
/** 
$datos['idcompraestado']=1;
$datos['idcompraestadotipo']=1;
$datos['idcompra']=7;
$datos['cefechaini']=null;//date('Y-m-d H:i:s');
$datos['cefechafin']=null;//date('Y-m-d H:i:s');
$objCE=new AbmCompraEstado();
$objCE->modificacion($datos);


echo("<br>----Hecho compraestado ----<br>");
*/

// COMPRA ITEM 
/** 
$datos['idcompraitem']=1;
$datos['idcompra']=5;
$datos['idproducto']=1;
$datos['cicantidad']=789565;
$objCI=new AbmCompraItem();
$objCI->modificacion($datos);
echo("<br>----Hecho compra item ----<br>");
*/










?>