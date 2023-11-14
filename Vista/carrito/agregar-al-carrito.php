<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el carrito está configurado en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Obtener el ID del producto desde la solicitud POST
    $idProducto = $_POST['idProducto'];

    // Agregar el ID del producto al carrito en la sesión
    $_SESSION['carrito'][] = $idProducto;

    // Puedes realizar otras acciones aquí, como guardar en la base de datos, etc.

    // Responder con un mensaje de éxito
    echo 'Producto agregado al carrito con éxito';
} else {
    // Si la solicitud no es POST, responder con un error
    http_response_code(400);
    echo 'Error: Solicitud no válida';
}
?>