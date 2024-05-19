<?php
include_once("../estructura/headPrivado.php");
$objAbmRol = new AbmRol();
$objAbmMenu = new AbmMenu();
$objAbmMenuRol = new AbmMenuRol();

$listaRol = $objAbmRol->buscar(null);
$listaMenu = $objAbmMenu->buscar(null);
foreach ($listaMenu as $key => $menuRol) {
  if ($menuRol->getId() == 1 || $menuRol->getId() == 55 || $menuRol->getId() == 53 || $menuRol->getId() == 51 || $menuRol->getId() == 56) {
    unset($listaMenu[$key]);
  }
}
$listaMenu = array_values($listaMenu);
?>

<div class="container p-3 text-center">
  <div class="row justify-content-between">
<div class="col-sm-4">
<span style="font-weight:600" class="fs-2 text-nowrap align-middle">Gestion de roles</span>
<button class="btn btn-success" id="nuevo">Nuevo Rol</button>
</div>
<div class="col-sm-2">
<a class="btn btn-secondary" href="../usuario/indexUsuario.php">Gestionar usuarios</a>
</div>


  </div>


  <div class="row justify-content-center mb-3">
    <div class="col-sm-6">
      <table class="table mt-3 bg-light rounded table-hover">
        <thead>
          <th style="width:10%">ID</th>
          <th style="width:40%">Nombre</th>
          <th style="width:10%"></th>

        </thead>

        <?php if (count($listaRol) > 0) {
          foreach ($listaRol as $rol) {
            $datosRol = [
              'idrol' => $rol->getId(),
              'roldescripcion' => $rol->getDescripcion()
            ]; ?>

            <tr>
              <td> <?php echo ($rol->getId()) ?></td>
              <td> <?php echo ($rol->getDescripcion()) ?></td>

              <td class="align-middle">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button class="btn btn-primary editar text-white d-flex justify-content-center align-items-center" data-rol='
          <?php echo json_encode($datosRol); ?>' style="width:30px;height:30px">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <?php
                  if ($rol->getId() != 1 && $rol->getId() != 2 && $rol->getId() != 3 && $rol->getId() != 4) {
                  ?>

                    <?php
                    if ($rol->getHabilitado() == 1) {
                    ?>
                      <button class="btn btn-danger eliminar text-white d-flex justify-content-center align-items-center" data-rol='<?php echo json_encode($datosRol); ?>' style="width:30px;height:30px">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    <?php
                    } else {
                    ?>
                      <button class="btn btn-success habilitar text-white d-flex justify-content-center align-items-center" data-rol='<?php echo json_encode($datosRol) ?>' style="width:30px;height:30px">
                        <i class="bi bi-plus-lg"></i>
                      </button>
                    <?php
                    }
                    ?>

                  <?php
                  }
                  ?>
                </div>
              </td>
            </tr>
        <?php
          } // fin for 
        } ?>
      </table>
    </div>
  </div>



</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="tituloModalEditar"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="form-group" id="formEditar">
        <div class="modal-body">
          <input type="hidden" name="idrol" id="enviado">
          <div class="mb-3">
            <label for="nombreRol" class="form-label">Nombre</label>
            <input type="text" class="form-control clickeable" name="roldescripcion" id="roldescripcion">
          </div>
          <div class="mb-3">
            <h5>Asignar accesos:</h5>
            <?php
            foreach ($listaMenu as $menu) {
              $nombreCheck = $menu->getNombre();
              echo '  <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" name="' . $menu->getId() . '">
              <label class="form-check-label" for="flexCheckDefault">
                ' . $nombreCheck . '
              </label>
            </div>';
            }
            ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="enviar">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Error</h5>
        <button type="button" style="color:white" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-error">
        Lo sentimos, se ha producido un error.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Éxito</h5>
        <button type="button" style="color:white" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Los cambios se guardaron correctamente.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title eliminar-title">Atención</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body eliminar-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger" id="aceptarEliminar">Deshabilitar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalHabilitar" tabindex="-1" aria-labelledby="habilitarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title eliminar-title">Habilitar Rol</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body habilitar-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" id="confirmarHabilitar">Habilitar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="../Js/rol.js"></script>
<?php

include_once("../estructura/footer.php");
?>