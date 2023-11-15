<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';
include_once '../../Control/AbmProducto.php';
include_once '../../Modelo/Producto.php';
include_once '../../Modelo/Conector/BaseDatos.php';

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
  echo '';
}

// Obtener el contenido del carrito desde la sesión
$carrito = $_SESSION['carrito'] ?? [];

$count = 0;
$objProducto = new AbmProducto();
$cantProductos = count($carrito);
$arregloProductos = [];
$total=0;
for ($i = 0; $i < $cantProductos; $i++) {
  $data = ["idproducto" => $carrito[$i]];
  $arregloProductos[$i] = $objProducto->buscar($data)[0];
  $total+=$arregloProductos[$i]->getPrecio();
}

// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Carrito</h2>
  <table class="table-striped d-flex justify-content-center">
    <tr>
      <th style="width:40%">Nombre</th>
      <th style="width:40%">Detalle</th>
      <th style="width:40%">Precio</th>

    </tr>
    <?php
    foreach ($arregloProductos as $Producto) {
    ?>
      <tr style="border-bottom:2px solid dodgerblue;">
        
        <td > <?php echo ($Producto->getNombre()) ?></td>
        <td> <?php echo ($Producto->getDetalle()) ?></td>
        <td> $<?php echo ($Producto->getPrecio()) ?></td>

        <td><i data-id="<?php echo ($Producto->getId()) ?>" class="btn btn-danger bi bi-x p-1 m-1"></i></td>
      </tr>
    <?php
      $count++;
    } //fin for 
    ?>
    <tr>
      <th style="width:100%">Valor total: $<?php echo $total ?></th>
    </tr>
  </table>
</div>

<?php
include_once '../estructura/footer.php';
?>