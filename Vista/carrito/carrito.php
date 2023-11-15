<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

session_start();

// Obtener el contenido del carrito desde la sesión
$carrito = $_SESSION['carrito'] ?? [];
$count = 0;
// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<div class="d-flex flex-wrap pb-5 justify-content-center">
  <?php
  foreach ($carrito as $unId) {
    $objProducto=new AbmProducto;
    $id=[
      "idproducto"=>$unId
    ];
    $unProducto=$objProducto->buscar($id)[0];
  ?>
    <div class="card m-3 justify-content-between"style="width: 18rem;max-height:400px;">
      <img src="../imagenes/<?php echo $unProducto->getId() ?>.jpg" class="card-img" style="max-height:200px;object-fit:contain" alt="...">
      <div class="card-body d-flex flex-column justify-content-end" style="max-height:200px">
        <h5 class="card-title"><?php echo ($unProducto->getNombre()) ?></h5>
        <p class="card-text"> <?php echo ($unProducto->getDetalle()) ?> </p>
        <p class="card-text"> <?php echo ("$" . $unProducto->getPrecio()) ?> </p>
      </div>
    </div>
  <?php
    $count++;
  } //fin for 
  ?>
</div>
<?php
/**
 * pasos a seguir_
 * 1) guardar los id de productos cuando el cliente hace click en ver carrito y enviarlos a un accion carrito
 * 2) en accion carrito cuan haga click en comprar cambiar el estado a preparacion
 * 3)  
 */
include_once '../estructura/footer.php';
?>