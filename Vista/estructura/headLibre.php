<?php
  //include_once("../../configuracion.php");
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
  <nav class="navbar navbar-expand-lg d-flex justify-content-around p-2 fs-3">
    <div class="container-fluid">
      <a class="navbar-brand" id="pagina-principal" href="../inicio/inicioIndex.php">Grupo N°5</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://github.com/Matias-Ignacio/PWD_2023_TPFinal"> <i class="bi bi-github"></i> </a>
          </li>

            <!--NOMBRE DE LA PAGINA   -->
          <li class="nav-item mx-5">
            <a class="nav-link" href="../inicio/inicioIndex.php" role="button"  aria-expanded="false">
              WESH-WESH
            </a>
          </li>
          <!--PRODUCTOS  -->
          <li class="nav-item mx-5">
            <a class="nav-link" href="../grilla/indexGrilla.php" role="button"  aria-expanded="false">
              Productos
            </a>
          </li>
          
          <!--REGISTRARSE-->
          <li class="nav-item mx-5">
            <a class="nav-link" href="../login/indexLogin.php" role="button" aria-expanded="false">
              Ingresar
            </a>
          </li>

        </ul>
      </div>
    </div>

  </nav>
