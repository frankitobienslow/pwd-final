<?php
include_once "../../configuracion.php";
$datos=data_submitted();

$session=new Session();
if(isset($datos['menurol'])){
    $session->setRol($datos['menurol']);
    $menu = menuPrincipal($session);
    echo $menu;
    //echo "PROBANDO: ".$session->getRolActual();
    //header("Location: ../grilla/indexGrilla.php?logeado=si");
}


function menuPrincipal($objSession){
    $objMenuRol=new AbmMenuRol();
    $menu = "";    
    $opcionRol = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"  data-bs-toggle="dropdown" aria-expanded="false">Rol</a><ul class="dropdown-menu">';
    $listaRol=$objSession->getRol(); // getRol llama al Abmrol
    $idRoles=[]; // guarda los id de roles en caso que tenga mas de 1 rol
    $i=0;
    foreach($listaRol as $rol){
      $idRoles[$i]=$rol->getId();
      $opcionRol .= '<li><a onclick="menurol('.$rol->getId().')" id=menurol'.$rol->getId().' class="dropdown-item" > '.$rol->getDescripcion().'</a></li>'; 
      //href="../estructura/accionEstructura.php?menurol='.$rol->getId().'"  id=menurol'.$rol->getId().'
      // id=menurol'.$rol->getId().' onclick="menurol('.$rol->getId().')"
      $i++;
    }// fin for 
    // GENERACION DEL MENU DINAMICO 
    $param['idrol'] = $objSession->getRolActual();
    $listaMenuRol=$objMenuRol->buscar($param);
    $listaPadre=array();
    $listaHijos=array();
    //echo $_SESSION["idRol"];
    foreach($listaMenuRol as $obj){
      if($obj->getObjMenu()->getObjMenuPadre()==null){
        array_push($listaPadre,$obj->getObjMenu());
      }// fin if 
      else{
        array_push($listaHijos,$obj->getObjMenu());
      }// fin else
    }// fin for 
    foreach($listaPadre as $objMenuPadre){
      $menu.='<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"  data-bs-toggle="dropdown" aria-expanded="false">';
      $menu .= $objMenuPadre->getNombre() . '</a><ul class="dropdown-menu">';
      foreach($listaHijos as $objMenuHijo){
        if($objMenuHijo->getobjMenuPadre()->getId() == $objMenuPadre->getId()){
          $menu .= '<li><a class="dropdown-item" href="'. $objMenuHijo->getDescripcion(). '">'.$objMenuHijo->getNombre().'</a></li>';  
        }// fin if 
      }// fin for
      $menu.='</ul></li>';
    }// fin for  
    $menu .= $opcionRol . '</ul></li>';;
    return $menu;
  }
?>