<?php
include_once '../../configuracion.php';

$objCE = new AbmCompraEstado();
$objCI = new AbmCompraItem();
$objCET = new AbmCompraEstadoTipo();
$objCompra = new AbmCompra();

// Verificar si se ha hecho clic en alguno de los botones
$idcompraestadotipo = isset($_GET['idcompraestadotipo']) ? $_GET['idcompraestadotipo'] : null;

$dato['idcompraestadotipo'] = $idcompraestadotipo;
$dato["cefechafin"] = "null";

$listaObjCE = $objCE->buscar($dato);

// Variable para almacenar el texto dinámico
$mensajeNoVentas = '';
$boton = "Ver detalle";
// Botón "En proceso"
if ($idcompraestadotipo == 2) {
    $mensajeNoVentas = 'No se registran ventas en proceso.';
    $boton = "Gestionar";
}
// Botón "Enviadas"
elseif ($idcompraestadotipo == 3) {
    $mensajeNoVentas = 'No se registran ventas enviadas.';
    $boton = "Gestionar";
}
// Botón "Entregadas"
elseif ($idcompraestadotipo == 4) {
    $mensajeNoVentas = 'No se registran ventas entregadas.';
    $listaObjCE = $objCE->buscar($dato);
}
// Botón "Canceladas"
elseif ($idcompraestadotipo == 5) {
    $mensajeNoVentas = 'No se registran ventas canceladas.';
    $listaObjCE = $objCE->buscar($dato);
} elseif ($idcompraestadotipo == 6) {
    $mensajeNoVentas = 'No se registran ventas pendientes.';
    $listaObjCE = $objCE->buscar($dato);
}
ob_clean();
include_once '../estructura/headPrivado.php';
?>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">
            <nav class="navbar navbar-expand-lg navbar-light mt-2 ">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown" style="font-weight:600">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $idcompraestadotipo == 2 ? 'active' : ''; ?>" href="?idcompraestadotipo=2">En proceso</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $idcompraestadotipo == 6 ? 'active' : ''; ?>" href="?idcompraestadotipo=6">Pendientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $idcompraestadotipo == 3 ? 'active' : ''; ?>" href="?idcompraestadotipo=3">Enviadas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $idcompraestadotipo == 4 ? 'active' : ''; ?>" href="?idcompraestadotipo=4">Entregadas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $idcompraestadotipo == 5 ? 'active' : ''; ?>" href="?idcompraestadotipo=5">Canceladas</a>
                        </li>
                    </ul>
                </div>
            </nav>
            </div>
        </div>

        <!-- Lista de compras -->
        <div id="listaCompras" class="mt-3" <?php echo $idcompraestadotipo ? '' : 'style="display: none;"'; ?>>
            <?php
            if (count($listaObjCE) >= 1) {
            ?>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <table class="table bg-light rounded">
                            <thead>
                                <tr>
                                    <th class="h6 fw-bolder"> ID</th>
                                    <th class="h6 fw-bolder">Cliente</th>
                                    <?php if ($idcompraestadotipo != 5) { ?>
                                        <th class="h6 fw-bolder">Monto</th>
                                    <?php } ?>
                                    <th class="h6 fw-bolder">Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($listaObjCE as $unaCE) {
                                    $monto = 0;
                                    $idcompra = $unaCE->getObjCompra()->getId();
                                    $datos["idcompra"] = $idcompra;
                                    ob_start();
                                    foreach ($objCI->buscar($datos) as $itemCompra) {
                                        $monto += ($itemCompra->getObjProducto()->getPrecio()) * ($itemCompra->getCantidad());
                                    }
                                    ob_end_clean();
                                ?>
                                    <tr>
                                        <td class="h6 fw-bolder align-middle"><?php echo $idcompra ?></th>
                                        <td class="h6 align-middle"><?php echo $objCompra->buscar($datos)[0]->getUsuario()->getNombre() ?></th>
                                            <?php if ($idcompraestadotipo != 5) { ?>
                                        <td class="h6 align-middle"><?php echo "$" . $monto; ?></th>
                                        <?php } ?>
                                        <td class="h6 align-middle"><?php echo $unaCE->getObjCompraEstadoTipo()->getDescripcion(); ?></td>
                                        <td class="text-center">
                                            <a href="verCompra.php?idcompra=<?php echo $idcompra; ?>" class="btn btn-info" style="width:100%;"><?php echo $boton ?></a>
                                        </td>
                                    </tr>
                                <?php
                                } // fin foreach
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-danger"><?php echo $mensajeNoVentas; ?></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

<?php
include_once '../estructura/footer.php';
?>