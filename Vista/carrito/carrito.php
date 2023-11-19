<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

// RECORIDO DE LOS PRODUCTOS CON SU IMAGEN, NOMBRE Y PRECIO
?>
<form class="form-group" action="./accionCarrito.php">
  <div class="container mt-3 text-center">
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
    <div class="btn btn-success mt-2 text-center" name="confirmarCompra" id="confirmarCompra">Confirmar compra</div>
  </div>

</form>

<?php
include_once '../estructura/footer.php';
?>