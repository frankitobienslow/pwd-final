<?php
include_once '../../configuracion.php';

$objSession = new Session();   

$esCliente = false;
$esGuest = false;

if ($objSession->validar()) {
  include_once '../estructura/headPrivado.php';
  if (($objSession->getRolActual()->getId()) == 3) {
    $esCliente = true;
  }
} else {
  include_once '../estructura/headLibre.php';
  $esGuest = true;
}

$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$objProducto = new AbmProducto();
$param["habilitado"] = 1;
$listaProductos = $objProducto->buscar($param);

// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<style>
  .cardProducto{
    transition: transform 0.2s, box-shadow 0.2s;
}

.cardProducto:hover{
  transform: translateY(-5px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}
.cardProducto button{
  background-color: #9f151e;
  transition: background-color 0.2s, transform 0.2s;
  margin-top:-5px;
}

.cardProducto button:hover{
  background-color:#c41b2a;
  transform:scale(1.05);
}

.guest{
  background-color: #9f151e;
  transition: background-color 0.2s, transform 0.2s;
  margin-top:-5px;
}

.guest:hover{
  background-color:#c41b2a;
  transform:scale(1.05);
}
</style>
<div id="alerta" class="alert alert-success" style="z-index:100; box-shadow: 0px 0px 14px -1px rgba(0,0,0,0.50);" role="alert">
</div>
<div class="d-flex flex-wrap pb-5 justify-content-center">
  <?php
  foreach ($listaProductos as $unProducto) {
    if ($unProducto->getStock() > 0) {
  ?>
      <div class="card m-4 cardProducto shadow-sm" style="max-width: 12rem; max-height:300px;">
        <img src="<?php echo $unProducto->getImagen(); ?>" class="card-img-top p-2" style="max-height: 200px; min-height:200px; object-fit: contain;" alt="Imagen del producto">
        <div class="card-body p-2" style="height: 200px;">
          <div class=" text-white">

          </div>
          <div class="row">
            <h5 class="card-text"><?php echo $unProducto->getNombre(); ?></h5>
          </div>
          <div class="row">
            <p class="card-text"><?php echo $unProducto->getDetalle(); ?></p>
          </div>
          <div class="row">
            <p class="card-text">$ <?php echo $unProducto->getPrecio(); ?></p>
          </div>
          </div>
        <div class="d-flex flex justify-content-center">
            <?php if ($esCliente) { ?>
              <button class="btn carrito text-white" data-id="<?php echo $unProducto->getId(); ?>">Añadir al Carrito</button>
            <?php } else if ($esGuest) { ?>
              <a href="../login/indexLogin.php" class="btn text-white guest">Añadir al Carrito</a>
            <?php } ?>
          </div>
      </div>
  <?php
    }
  } //fin for 
  ?>
</div>
<script type="text/javascript" src="../Js/grilla.js"></script>
<?php
include_once "../estructura/footer.php"; ?>