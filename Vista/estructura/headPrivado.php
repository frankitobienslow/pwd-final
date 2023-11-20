<?php
include_once("../../configuracion.php");
$objSession = new Session();
$objAbmMenuRol = new AbmMenuRol();

if ($objSession->validar() && $objSession->permisos()) {    //&& $objSession->permisos()
  $menu = $objAbmMenuRol->menuPrincipal($objSession);
  $UsuarioNombre = $objSession->getUsuario()->getNombre();
} else {
  header("Location: ../index.php");
}
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
  <script src="../Js/menu.js"></script>

</head>

<body>

  <nav class="navbar navbar-expand-lg bg-ligth p-2 fs-3 ">
    <div class="container-fluid" >
      <a class="navbar-brand" id="pagina-principal" href="../../index.php">Grupo N°5</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://github.com/Matias-Ignacio/PWD_2023_TPFinal"> <i class="bi bi-github"></i> </a>
          </li>
          <!-- Menu Dinamico -->
          <ul class="navbar-nav" id="resultadoMenu">
            <?php   echo $menu; ?>
          </ul>
          <?php include_once ("carritoIcono.php");?> 
        </ul>  
        <ul class="navbar-nav" >    
          <li class="navbar-item">
            <a class="nav-link "  role="button" aria-expanded="false">Usuario: <?php echo $UsuarioNombre."  "; ?></a>   
          </li>        
          <li  class="nav-item ">
            <a class="nav-link "  href="../login/accionLogin.php?accion=cerrar" role="button" aria-expanded="false">Salir</a>              
          </li>          
        </ul>
      </div>
    </div>

  </nav>