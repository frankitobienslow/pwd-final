<?php
//$Titulo="Lista Compra Cliente y estado";
include_once("../../configuracion.php");

$datos = data_submitted();
$datos["cefechafin"] = "null";
$objCE = new AbmCompraEstado;
$objCE = $objCE->buscar($datos);
$cancelar = false;
if ($objCE[0]->getObjCompraEstadoTipo()->getId() == 6) {
    $cancelar = true;
}
$objCompraItem = new AbmCompraItem();
$listaCompraItem = $objCompraItem->buscar($datos);
ob_clean();
include_once "../estructura/headPrivado.php";
?>
<div class="row justify-content-center p-3">
    <div class="col-sm-8">
        <table class="table bg-light rounded">
            <thead>
                <th></th>
                <th class="h6 fw-bolder">Producto</th>
                <th class="h6 fw-bolder text-center">Cantidad</th>
                <th class="h6 fw-bolder text-center">Monto</th>
            </thead>
            <tbody>
                <?php if (count($listaCompraItem) > 0) {
                    for ($i = 0; $i < count($listaCompraItem); $i++) { ?>
                        <tr>
                            <td class="text-center"> <img src="<?php echo $listaCompraItem[$i]->getObjProducto()->getImagen(); ?>" class="rounded" style="max-width:100px; max-height:50px"></td>
                            <td class="align-middle h6"> <?php echo ($listaCompraItem[$i]->getObjProducto()->getNombre()) . " " . ($listaCompraItem[$i]->getObjProducto()->getDetalle()) ?></td>
                            <?php if ($listaCompraItem[$i]->getCantidad() > 0) { ?>
                                <td class="align-middle h6 text-center"> <?php echo ($listaCompraItem[$i]->getCantidad()) ?></td>
                                <td class="align-middle h6 text-center"> $<?php echo ($listaCompraItem[$i]->getObjProducto()->getPrecio()*$listaCompraItem[$i]->getCantidad()) ?></td>
                            <?php } else { ?>
                                <td class="align-middle h6 text-danger text-center">❌Producto Cancelado</td>
                                
                        </tr>
                <?php }
                }
                    } else { ?>
                <td colspan="3">
                    <div class="alert alert-danger" role="alert">
                        Usted no tiene compras realizadas hasta el momento
                    </div>
                </td>
            <?php } ?>
            </tbody>
        </table>

        <?php if ($cancelar) {
            echo  ' 
        <div class="alert alert-warning text-center">
        <div class="mb-2">Lamentablemente tuvimos que cancelar algunos productos de tu pedido. ¿Desea continuar con la compra?</div>
        <div class="row justify-content-center">
        <div class="col col-sm-2"><button id="aceptarCompra"  class="btn btn-success" data-id="' . $datos["idcompra"] . '">Continuar</button></div>
        <div class="col col-sm-2"><button id="cancelarCompra"  class="btn btn-danger" data-id="' . $datos["idcompra"] . '">Cancelar</button></div>
        </div>
        </div>';
        } ?>
        <div><a href="indexCompraCliente.php" class="btn btn-secondary">Atrás</a></div>
    </div>
</div>

<!-- Modal Success -->
<div class="modal fade" id="modalsuccess" tabindex="-1" aria-labelledby="modalsuccessLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalsuccessLabel">Excelente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Se procederá con la compra.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modalerror" tabindex="-1" aria-labelledby="modalerrorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalerrorLabel">Lo sentimos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Lamentamos la mala experiencia, cancelaremos el pedido.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#cancelarCompra").click(function() {
            $.ajax({
                url: "../compra/accionVerCompra.php",
                method: "POST",
                data: {
                    cancelarCompra: $(this).data('id')
                },
                success: function(response) {
                    $("#modalerror").modal("show");
                }
            })
        })

        $("#aceptarCompra").click(function() {
            $.ajax({
                url: "../compra/accionVerCompra.php",
                method: "POST",
                data: {
                    aceptarCompra: $(this).data('id')
                },
                success: function(response) {
                    $("#modalsuccess").modal("show");

                }
            })
        })
    })

    $('#modalsuccess').on('hidden.bs.modal', function() {
        window.location.href = '../compra/indexCompraCliente.php';
    });

    // Redirigir al cerrar el modal de error
    $('#modalerror').on('hidden.bs.modal', function() {
        window.location.href = '../compra/indexCompraCliente.php';
    });
</script>

<?php
include_once "../estructura/footer.php";
?>