<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';
include_once '../../Control/AbmProducto.php';
include_once '../../Modelo/Producto.php';
include_once '../../Modelo/Conector/BaseDatos.php';

// Obtener el contenido del carrito desde la sesión

$carrito = $_SESSION['carrito'] ?? [];
$count = 0;
$objProducto = new AbmProducto();
$cantProductos = count($carrito);
$arregloProductos = [];
$total = 0;
for ($i = 0; $i < $cantProductos; $i++) {
  $data = ["idproducto" => $carrito[$i]];
  $arregloProductos[$i] = $objProducto->buscar($data)[0];
  $total += $arregloProductos[$i]->getPrecio();
}

// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<form class="form-group" action="#">
  <div class="container mt-3">
    <h2 style="text-align: center; color:dodgerblue;">Carrito</h2>
    <table class="table-striped d-flex justify-content-center text-center">
      <tr>
        <th style="width:40%;border:2px solid dodgerblue">Nombre</th>
        <th style="width:40%;border:2px solid dodgerblue">Detalle</th>
        <th style="width:40%;border:2px solid dodgerblue">Precio</th>

      </tr>
      <?php
      foreach ($arregloProductos as $Producto) {
      ?>
        <tr style="border:2px solid dodgerblue;" class="producto" data-id="<?php echo ($Producto->getId()) ?>">

          <td style="border:2px solid dodgerblue;"> <?php echo ($Producto->getNombre()) ?></td>
          <td style="bordersolid dodgerblue;text-align:center"> <?php echo ($Producto->getDetalle()) ?></td>
          <td style="border:2px solid dodgerblue;" class="precio"> $<?php echo ($Producto->getPrecio()) ?></td>
          <td><i data-id="<?php echo ($Producto->getId()) ?>" class="btn btn-danger bi bi-x p-1 m-1 eliminarCarrito"></i></td>
        </tr>
      <?php
        $count++;
      } //fin for 
      ?>
      <th><div class="btn btn-success mt-2" id="confirmarCompra" style="width:275%;">Confirmar compra</div></th>
      
    </table>
  </div>
  
</form>
<?php
include_once '../estructura/footer.php';
?>