<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

$objSession->getCarrito();

// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<form class="form-group" action="./accionCarrito.php" method='POST'>
  <div class="container mt-3 text-center" id="tablaContainer">
    <h2 style="text-align: center; color:dodgerblue;">Carrito</h2>
    <table class="table-striped d-flex justify-content-center text-center" style="display:none" id="tablaProductos">
      <tr>
        <th style="width:40%;border:2px solid dodgerblue">Nombre</th>
        <th style="width:40%;border:2px solid dodgerblue">Detalle</th>
        <th style="width:40%;border:2px solid dodgerblue">Cantidad</th>
        <th style="width:40%;border:2px solid dodgerblue">Stock</th>
        <th style="width:40%;border:2px solid dodgerblue">Precio</th>
      </tr>
        
    </table>
    
  </div>

</form>


<!-- Modal -->
<div class="modal fade bg-light" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLabel">Aviso de Compra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Su compra fue realizada exitosamente. Dirijase a ver compras para su seguimiento.  
      </div>
      <div class="modal-footer">
        <button type="button" id="cerrarModal" class="btn btn-outline-info" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




<script>
 

</script>


<?php
include_once '../estructura/footer.php';
?>

