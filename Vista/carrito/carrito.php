<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

?>
<title>Carrito</title>
<div class="container mt-3 text-center" id="tablaContainer">
    <h2 style="color:#9f151e;">Carrito</h2>
      <table class="table table-striped mx-auto rounded bg-light" id="tablaProductos" style="width:60%">
        <tr>
          <th style="width: 15%;"></th>
          <th style="width: 30%;">Nombre</th>
          <th style="width: 20%;">Detalle</th>
          <th style="width: 15%;">Cantidad</th>
          <th style="width: 15%;">Stock</th>
          <th style="width: 15%;">Precio</th>
          <th style="width: 10%;"></th>
        </tr>
      </table>
</div>

<!-- Modal -->

<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="InfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="../Js/carrito.js"></script>
<?php
include_once '../estructura/footer.php';
?>