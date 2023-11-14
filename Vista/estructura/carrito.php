<?php
include_once '../../configuracion.php';
include_once 'headPrivado.php';


$objProducto=new AbmProducto();
$listaProductos=$objProducto->buscar(null);

// generacion aleatoria de precios
$precio=array();
for($i=0;$i<count($listaProductos);$i++){
    $precio[$i]=rand(1000,100000);
}// fin for 
$count=0;
// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<div class="container m-5">
  <div class="row">
    <div class="col-10">
    <div class="d-flex flex-wrap">
      <?php 
        foreach($listaProductos as $unProducto){
          
          ?>
          
            <div class="card m-3 d-flex align-items-start flex-column" style="width: 18rem;">
              <img src="../imagenes/<?php echo $unProducto->getId()?>.jpg" class="card-img-top" style="max-width: 200px;" alt="...">
                <div class="card-body">
                <h5 class="card-title" id="nombreProducto"><?php echo($unProducto->getNombre()) ?></h5>
                <p class="card-text" id="detalle"> <?php echo($unProducto->getDetalle()) ?> </p>
                <p class="card-text" id="precio"> <?php echo("$".$precio[$count]) ?> </p>
                <a href="#" class="btn btn-primary" id="carrito">Añadir Carrito</a>
                </div>
            </div>
          

          <?php
          $count++;
        }//fin for 
      ?>
    </div>

  </div>
  <div class="col-2" id="carrito">
    <h3>Carrito</h3> 
    <i class="bi bi-cart4"></i>
    <p id="count">


    </p>
  </div>
  </div>

</div>

<?php 
/**
 * pasos a seguir_
 * 1) guardar los id de productos cuando el cliente hace click en ver carrito y enviarlos a un accion carrito
 * 2) en accion carrito cuan haga click en comprar cambiar el estado a preparacion
 * 3)  
 */
?>



<?php
include_once 'footer.php';
?>
