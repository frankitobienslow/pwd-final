<?php
include_once("../../configuracion.php");
$objSession = new Session();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/ico" href="/favicon.ico">
  <?php if ($objSession->getPaginaActual() != null) { ?>
    <title>
      <?php echo $objSession->getPaginaActual()->getNombre() . " | wesh wesh"; ?>
    </title>
  <?php } ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--LINK BOOSTRAP -->
  <link rel="stylesheet" href="../librerias/bootstrap5/css/bootstrap.min.css">

  <!--LINK ICONOS BOOTSTRAP  -->
  <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.css">

  <!-- LINK CSS -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">

  <!--LINK JS - BOOTSTRAP-->
  <script src="../librerias/bootstrap5/js/bootstrap.min.js"></script>

  <!--LINK JS - JQUERY-->
  <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

</head>

<body>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="max-height:50px;">
      <div class="container-fluid">
        <a class="navbar-brand" href="../inicio/inicioIndex.php"> <img src='../imagenes/logo.svg' style="max-width:70px; position:relative; top:10px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="../grilla/indexGrilla.php" role="button" aria-expanded="false">
                Productos
              </a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="btn btn-success" href="../login/indexLogin.php" role="button" aria-expanded="false">
                Iniciar sesión
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div id="contenido" style="min-height: calc(100vh - 60px); background-image:url(../imagenes/background.jpg);background-repeat:repeat;background-size:800px">