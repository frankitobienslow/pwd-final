<?php
include_once "../estructura/headPrivado.php";
$objAbmUsuario = new AbmUsuario();
$idUsuario = $objSession->getUsuario()->getId();
$nombreUsuario = $objSession->getUsuario()->getNombre();
$mailUsuario = $objSession->getUsuario()->getMail();

?>
<div class="container p-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center fs-3">¡Bienvenido <?php echo $nombreUsuario ?>!</div>
                    <div class="card-text mt-3">
                        <div class="mb-1">
                            <span>Nombre de Usuario:</span>
                            <span><?php echo $nombreUsuario ?></span>
                        </div>
                        <div class="mb-3">
                            <span>Correo electrónico:</span>
                            <span><?php echo $mailUsuario ?></span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-warning" id="editar" data-usuario=<?php echo $idUsuario ?> type="button">Editar Perfil</button>
                    </div>
                </div>
            </div>
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
                    <input type="hidden" name="idusuario" value="<?php echo $idUsuario ?>" id="enviado">
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control clickeable" name="usnombre" value="<?php echo $nombreUsuario;?>">
                    </div>
                    <div class="mb-3">
                        <label for="mailUsuario" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control clickeable" name="usmail" value="<?php echo $mailUsuario;?>">
                    </div>
                    <div class="mb-3">
                        <label for="passUsuario" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control clickeable" name="uspass" id="passUsuario">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassUsuario" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control clickeable" name="confirmPassword" id="confirmPassUsuario">
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

<script type="text/javascript" src="../Js/perfil.js"></script>

<?php
include_once "../estructura/footer.php";
?>