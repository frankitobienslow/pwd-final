<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si el carrito está configurado en la sesión
  if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
  }
  // Obtener el ID del producto desde la solicitud POST
  $idProducto = $_POST['idProducto'];

  // Agregar el ID del producto al carrito en la sesión
  $index = array_search($idProducto, $_SESSION['carrito']);

  // Verificar si se encontró el elemento
  if ($index !== false) {
    // Eliminar el elemento del arreglo
    unset($_SESSION['carrito'][$index]);
  }
  var_dump($_SESSION['carrito']);
} else {
  // Si la solicitud no es POST, responder con un error
  http_response_code(400);
  echo "No se recibio un POST";
}
