<?php
include_once "../../configuracion.php";
include_once "../../Control/AbmProducto.php";
include_once "../estructura/headLibre.php";
$objProducto = new AbmProducto;
$listaProductos = $objProducto->buscar(null);
?>
<div class="container-fluid"style="border:2px black solid;">
<div class="row">
    ola
</div>
</div>

</div>

<?php
include_once "../estructura/footer.php";
