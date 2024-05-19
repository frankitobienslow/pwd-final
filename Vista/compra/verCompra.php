<?php
include_once '../../configuracion.php';
$datos = data_submitted();
$objCI = new AbmCompraItem();
$listaItemDeCompra = $objCI->buscar($datos); // devuelve un array de obj ite con el id compra dado
$idcompra = $datos["idcompra"];
$objCE = new AbmCompraEstado;
$datos["cefechafin"]="null";
$objCE = $objCE->buscar($datos)[0];
$estadotipo = $objCE->getObjCompraEstadoTipo();

if (isset($datos['idcompra'])) {
  ob_clean();
  include_once '../estructura/headPrivado.php';
?>
  <!--Tabla de productos pagados -->
  <div class="container p-3">
    <div class="row justify-content-start align-items-center">
      <div class="col-sm-3">
        <h3> ID Compra: <?php echo ($idcompra); ?></h3>
      </div>
      <div class="col">
        <h6><?php echo $estadotipo->getDescripcion()." desde ".$objCE->getFechaInicio()?></h6>
      </div>
    </div>
    <table class="table  bg-light rounded">
      <thead>
        <tr class="text-center">
          <th class="h5">Item ID</th>
          <th class="h5">Producto</th>
          <th class="h5">Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($listaItemDeCompra) >= 1) {
          foreach ($listaItemDeCompra as $unItem) {
        ?>
            <tr id="fila_<?php echo $unItem->getId(); ?>" class="text-center" <?php if($unItem->getCantidad()==0){echo 'style="background-color:FF7A7A"';} ?>>
              <th scope="row" class="fs-5"><?php echo ($unItem->getId()); ?></th>
              <td class="fs-5"><?php echo ($unItem->getObjProducto()->getNombre())." ".($unItem->getObjProducto()->getDetalle()) ?></td>
              <td class="fs-5"><?php if($unItem->getCantidad()!=0){echo ($unItem->getCantidad());}else{echo '❌Producto Cancelado';} ?></td>
              <td id="respuesta" class="<?php echo ($idcompra); ?>">
                <?php
                if ($estadotipo->getId() == 2 && $unItem->getCantidad()!=0) {
                  echo '<button class="btn btn-danger cancelar" id="'.($unItem->getId()).'"><i class="bi bi-x-lg"></i></button>';
                }
                ?>
              </td>
            </tr>
          <?php
          } // fin for 
          ?>

        <?php
        } // fin if 
        else {
        ?>

          <tr>
            <td colspan="4" class="alert alert-danger">
              No hay productos.
            </td>
          </tr>
        <?php

        } ?>

      </tbody>

    </table>
    <?php
    if ($estadotipo->getId() == 2) {
      echo ' <div id="contenedor" class="text-center container">
              <button class="btn btn-lg btn-success" id="enviar">Procesar venta</button>
            </div>';
    }else if($estadotipo->getId()==3){
      echo  ' <div id="contenedor" class="text-center container"><button  class="btn btn-success btn-lg entregado" data-id="'.$idcompra.'">Confirmar entrega</button></div>';
    }
    ?>

    <div class="container"> <a href="indexCompraDeposito.php?idcompraestadotipo=<?php echo $estadotipo->getId()?>"><button class="btn btn-secondary mb-5 text-white">Atrás</button></a></div>
  <?php

} // fin if
else {
  echo ("Algo salió mal");
} // fin else
  ?>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Éxito</h5>
        <button type="button" style="color:white" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Se actualizó el estado de la compra.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

  <script src="../js/compraDeposito.js"></script>
  <?php
  include_once '../estructura/footer.php';
  ?>