<?php
include_once("../../configuracion.php");
$objSession = new Session();
$objAbmMenuRol = new AbmMenuRol();

$menu = "";
$UsuarioNombre = "";

if ($objSession->getRol() == null) {
    header("Location: ../login/indexLogin.php");
}

if ($objSession->validar() && $objSession->permisos()) {    //&& $objSession->permisos()
    $menu = $objAbmMenuRol->menuPrincipal($objSession);
    $UsuarioRol = $objSession->getRolActual()->getDescripcion();
    $UsuarioNombre .= $objSession->getUsuario()->getNombre() . " (" . $UsuarioRol . ")";
} else {
    header("Location: ../login/indexLogin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/ico" href="/favicon.ico">
    <?php if ($objSession->getPaginaActual() != null) {
        if ($objSession->getPaginaActual()->getId() == 51) {
            echo "<title>Inicio | wesh wesh</title>";
        } else if ($objSession->getPaginaActual()->getId() == 56) {
            echo "<title>Editar perfil | wesh wesh</title>";
        } else if ($objSession->getPaginaActual()->getId() == 55) {
            echo "<title>Venta - Detalles | wesh wesh</title>";
        } else if ($objSession->getPaginaActual()->getId() == 53) {
            echo "<title>Compra - Detalles | wesh wesh</title>";
        } else {
            echo "<title>" . $objSession->getPaginaActual()->getNombre() . " | wesh wesh</title>";
        }
    }
    ?>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="../Js/menu.js"></script>

</head>

<body style="background-image:url(../imagenes/background.jpg);background-repeat:repeat;background-size:800px">
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="max-height:50px;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../inicio/inicioIndex.php"> <img src='../imagenes/logo.svg' style="max-width:70px; position:relative; top:10px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <!-- Menu Dinamico -->
                        <ul class="navbar-nav" id="resultadoMenu">
                            <?php echo $menu; ?>
                        </ul>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown"> <!-- Agregamos la clase 'dropdown' -->
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $UsuarioNombre; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdown" style="min-width:100px;">
                                <li><a class="dropdown-item p-2" href="../usuario/indexPerfil.php">Editar perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li> <a class="dropdown-item text-danger p-2" href="../login/accionLogin.php?accion=cerrar" role="button"><i class="bi bi-box-arrow-right text-danger"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="contenido" style="min-height: calc(100vh - 60px);">