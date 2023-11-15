<?php
include_once '../../configuracion.php';
include_once '../../Control/AbmProducto.php';
include_once '../../Modelo/Producto.php';
include_once '../../Modelo/Conector/BaseDatos.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si el carrito está configurado en la sesión
  if (!isset($_SESSION['cantCarrito'])) {
      $_SESSION['cantCarrito'] = 0;
  }

  // Obtener el ID del producto desde la solicitud POST
  $cantCarrito = $_POST['cantCarrito'];

  $_SESSION['cantCarrito'] = $cantCarrito;


} else {
  // Si la solicitud no es POST, responder con un error
  http_response_code(400);
  echo '';
}

// Obtener el contenido del carrito desde la sesión
$cantCarrito = $_SESSION['cantCarrito'] ?? 0;

?>
<li class="nav-item">
    <a class="nav-link active" aria-current="page" href="../carrito/carrito.php"> <i class="bi bi-cart4"></i> <span id="cantCarrito" style="font-size:20px; float:right;font-weight:bolder"><?php echo $cantCarrito ?><span></a>
</li>