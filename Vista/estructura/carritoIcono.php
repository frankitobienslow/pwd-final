<?php
include_once '../../configuracion.php';


$cantCarrito = count($_SESSION['carrito'] ?? []);

?>
<div class="container">
    <a aria-current="page" href="../carrito/carrito.php"> <i class="bi bi-cart4"></i> <span id="cantCarrito" style="font-size:20px;font-weight:bolder;text-decoration:none;"><?php echo $cantCarrito ?><span></a>
</div>