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

</head>
<?php 
  // Parte de verificacion de permisos 
  //$objSession=new Session();
  //$respuesta=$objSession->validar();
 // if($respuesta){
    // pregunta que rol tiene el usuario para mostrar la
    // informacion en funcion de su rol  



  //}// fin if 
  //else{
    // Manda al usuario no validado al login (faltaria la carpeta login)
   // header("Location: ../usuario/index.php");
  //}// fin else
?>

<body>
  <nav class="navbar navbar-expand-lg bg-light p-2 fs-3">
    <div class="container-fluid">
      <a class="navbar-brand" id="pagina-principal" href="../estructura/principal.php">Grupo N°5</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul cl ass="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="https://github.com/AlexisCasimiro/pwd"> <i class="bi bi-github"></i> </a>
          </li>
          <!--DROPDOWN TP1 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button"  data-bs-toggle="dropdown" aria-expanded="false">
              Gestion Usuarios
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Ver Compras</a></li>
              <li><a class="dropdown-item" href="#">Baja usuario</a></li>
              <li><a class="dropdown-item" href="#">Ver Usuarios</a></li>
              
            </ul>
          </li>
          <!--DROPDOWN TP2 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Gestion Rol
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../tp2/ejercicio3.php">Cambiar Rol</a></li>
              <li><a class="dropdown-item" href="../tp2/ejercicio4.php">Nuevo Rol</a></li>
            </ul>
          </li>


          <!--DROPDOWN TP3 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Registrarse
            </a>
          </li>


          <!--DROPDOWN TP4 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Salir
            </a>

          </li>

        </ul>
      </div>
    </div>

  </nav>
