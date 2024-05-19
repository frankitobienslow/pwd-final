<?php
include_once "../estructura/headPrivado.php";
$objAbmUsuario = new AbmUsuario();
$objAbmRol=new AbmRol();
$listaUsuarios = $objAbmUsuario->buscar(null);
$listaRol=$objAbmRol->buscar(null);
?>
<div class="container p-3">

    <h2 class="text-nowrap">Gestion de usuarios</h2>


    <div class="row justify-content-center">
        <div class="col-sm-6">
            <table class="table rounded bg-light table-hover">
                <thead>
                    <th style="width:10%">ID</th>
                    <th style="width:40%">Nombre</th>
                    <th style="width:10%">Email</th>
                    <th style="width:10%"></th>

                </thead>

                <?php if (count($listaUsuarios) > 0) {
                    foreach ($listaUsuarios as $usuario) {
                        $datosUsuario = [
                            'idusuario' => $usuario->getId(),
                            'usnombre' => $usuario->getNombre(),
                            'usmail' => $usuario->getMail()
                        ]; ?>

                        <tr>
                            <td> <?php echo ($usuario->getId()) ?></td>
                            <td> <?php echo ($usuario->getNombre()) ?></td>
                            <td> <?php echo ($usuario->getMail()) ?></td>

                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-primary editar text-white d-flex justify-content-center align-items-center" data-usuario='
          <?php echo json_encode($datosUsuario); ?>' style="width:30px;height:30px">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <?php
                                    if ($usuario->getId() != 10) {
                                    ?>

                                        <?php
                                        if ($usuario->getHabilitado() == 1) {
                                        ?>
                                            <button class="btn btn-danger eliminar text-white d-flex justify-content-center align-items-center" data-usuario='<?php echo json_encode($datosUsuario); ?>' style="width:30px;height:30px">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn btn-success habilitar text-white d-flex justify-content-center align-items-center" data-usuario='<?php echo json_encode($datosUsuario) ?>' style="width:30px;height:30px">
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
          <input type="hidden" name="idusuario" id="enviado">
          <div class="mb-3">
            <h5>Asignar roles:</h5>
            <?php
            foreach ($listaRol as $rol) {
              $rolCheck = $rol->getDescripcion();
              echo '  <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" name="' . $rol->getId() . '">
              <label class="form-check-label" for="flexCheckDefault">
                ' . $rolCheck . '
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
        <h5 class="modal-title eliminar-title">Habilitar Usuario</h5>
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

<script type="text/javascript" src="../Js/usuario.js"></script>

<?php
include_once "../estructura/footer.php";
?>