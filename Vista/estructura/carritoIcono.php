<?php
include_once '../../configuracion.php';


$cantCarrito = count($_SESSION['carrito'] ?? []);

?>
<li class="nav-item">
    <a class="nav-link active" aria-current="page" href="../carrito/carrito.php"> <i class="bi bi-cart4"></i> <span id="cantCarrito" style="font-size:20px; float:right;font-weight:bolder"><?php echo $cantCarrito ?><span></a>
</li>