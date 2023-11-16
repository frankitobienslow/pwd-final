<?php
include_once("../../configuracion.php");

$objSession=new Session();

  // Parte de verificacion de permisos 
  $menu = "";    
  $opcionRol = "";  
  $respuesta=$objSession->validar();
  //var_dump($respuesta);
  if($respuesta){
    // pregunta que rol tiene el usuario para mostrar la
    // informacion en funcion de su rol  
    $objRoles=$objSession->getRol(); // getRol llama al AbmUsuarioRol
    $idRoles=[]; // guarda los id de roles en caso que tenga mas de 1 rol
    $objMenuRol=new AbmMenuRol();
    $i=0;
    foreach($objRoles as $rol){
      $idRoles[$i]=$rol->getObjRol()->getId();
      $i++;
    }// fin for 
    $idRol=max($idRoles); // 1) ADM  2) Deposito  3) Cliente
    
    // GENERACION DEL MENU DINAMICO 
    $param['idrol']=$idRol;
    $listaMenuRol=$objMenuRol->buscar($param);
    $listaPadre=array();
    $listaHijos=array();
    //echo($idRol);
    foreach($listaMenuRol as $obj){
      if($obj->getObjMenu()->getObjMenuPadre()==null){
        array_push($listaPadre,$obj->getObjMenu());
      }// fin if 
      else{
        array_push($listaHijos,$obj->getObjMenu());
      }// fin else
      
    }// fin for 
    
    $menu="";

      // ARMADO DEL MENU SEGUN EL ROL 
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

     

  }// fin if 
  else{
    // Manda al usuario no validado al login 
    header("Location: ../inicio/inicioIndex.php");
  }// fin else
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--LINK BOOSTRAP -->
  <link rel="stylesheet" href="../librerias/bootstrap5/css/bootstrap.min.css">


  <!--LINK ICONOS BOOTSTRAP  -->
  <link rel="stylesheet" href="../librerias/node_modules/bootstrap-icons/font/bootstrap-icons.css">

  <!-- LINK CSS -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">


  <!--LINK JS - BOOTSTRAP-->
  <script src="../librerias/bootstrap5/js/bootstrap.min.js"></script>

  <!--LINK JS - JQUERY-->
  <script src="../librerias/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../Js/main.js"></script>

</head>


<body>
  <nav class="navbar navbar-expand-lg bg-light p-2 fs-3">
    <div class="container-fluid">
      <a class="navbar-brand" id="pagina-principal" href="../../index.php">Grupo N°5</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://github.com/Matias-Ignacio/PWD_2023_TPFinal"> <i class="bi bi-github"></i> </a>
          </li>

          <!--DROPDOWN TP3 -->
          <li class="nav-item">
            <a class="nav-link" href="../login/indexLogin.php" role="button" aria-expanded="false">
              Ingresar
            </a>
          </li>
          <?php    
          if($objSession->activa()){
            echo $menu;
            echo $opcionRol;
          }
      ?>


          <!--DROPDOWN TP4 -->
          <li class="nav-item">
            <a class="nav-link" href="../login/accionLogin.php?accion=cerrar" role="button" aria-expanded="false">
              Salir
            </a>
          </li>
       <?php //include_once ("carritoIcono.php");?>
        </ul>
      </div>
    </div>

  </nav>