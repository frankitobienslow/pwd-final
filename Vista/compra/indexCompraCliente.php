<?php
$Titulo = "Lista Compra Cliente y estado";
include_once "../../configuracion.php";
$session = new Session();
$carrito = false;
$idUsuario = $session->getUsuario()->getId();
$objAbmCompraEstado = new AbmCompraEstado();
$objAbmCompra = new AbmCompra();
$objAbmCompraItem = new AbmCompraItem();
$dato["idusuario"] = $idUsuario;
$comprasCliente = $objAbmCompra->buscar($dato);
$cantCompras = count($comprasCliente);
$listaObjCompraEstado = []; // Inicializar la variable aquí
ob_end_clean();
include_once "../estructura/headPrivado.php";
?>

<div class="container">
    <?php if (count($comprasCliente) > 0) { ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped rounded mt-5 bg-light">
                    <thead>
                        <tr>
                            <th scope="col" class="h6 fw-bold">Número de Compra</th>
                            <th scope="col" class="h6 fw-bold">Estado</th>
                            <th scope="col" class="h6 fw-bold">Fecha</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($comprasCliente as $compra) {
                            $listaObjCompraEstado = $objAbmCompraEstado->buscar(["idcompra" => $compra->getId(), "cefechafin" => "null"]);
                            foreach ($listaObjCompraEstado as $compraEstado) {
                                if ($compraEstado->getObjCompraEstadoTipo()->getId() == 1) {
                                    $carrito = true;
                                    continue;
                                }
                        ?>
                                <tr>
                                    <td class="align-middle h6"><?php echo $compraEstado->getObjCompra()->getId(); ?></td>
                                    <td class="align-middle h6"><?php echo $compraEstado->getObjCompraEstadoTipo()->getDescripcion(); ?></td>
                                    <td class="align-middle h6"><?php echo $compraEstado->getFechaInicio(); ?></td>
                                    <td><a href="verDetalles.php?idcompra=<?php echo $compraEstado->getObjCompra()->getId(); ?>" class="btn btn-info" style="width:100%;">Ver detalle</a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($carrito) { ?>
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <div class="alert alert-warning text-center">Tiene productos en el carrito <br>
                        <a class="btn btn-success mt-3" href="../carrito/carrito.php">Ir al carrito</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger">Usted no tiene compras realizadas hasta el momento</div>
            </div>
        </div>
        </div>
    <?php } ?>
</div>

<?php
include_once "../estructura/footer.php";
?>