<?php
    include_once '../../configuracion.php';
    include_once '../estructura/headPrivado.php';
// objCE = obj compra estado
// objCI = obj compra item
$objCE=new AbmCompraEstado();
$objCI=new AbmCompraItem();
$dato['idcompraestadotipo']=2;
$listaObjCE=$objCE->buscar($dato);
/** 
foreach($listaObjCE as $unaCE){
    echo("**** COMPRAS CON ESTADO PAGADO ****");
    $idcompra=$unaCE->getObjCompra()->getId();
    echo("<br>".$unaCE->getObjCompra()->getId()."<br>");
    $datoC['idcompra']=$idcompra;
    $listaItem=$objCI->buscar($datoC);
    foreach($listaItem as $unItem){
        echo("----------------------------------");
        echo("<br> idProducto:  ".$unItem->getObjProducto()->getNombre()."<br>");
        echo("<br> Cantidad:  ".$unItem->getCantidad()."<br>");
        echo("---------------------------------- <br>");

    }// fin for 
    echo("<br> **************************************** <br>");


}// fin for 
*/

?>

<main>
    <div class="container">
    <table class="table table-striped table-bordered mt-5">
        <thead>
            <tr>
            <th scope="col" class="h5 fw-bolder"> ID Compra</th>
            <th scope="col" class="h5 fw-bolder">Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row" class="h5 fw-bolder">1</th>
            <td class="h5">Mark</td>
            <td class="h5"><button type="button" id="ver" class="btn btn-info">Ver Productos</button></td>
            </tr>
            <tr><td colspan="3" id="verDetalle"></td></tr>
            
        </tbody>
</table>
    </div>
</main>    

<script>
    $(document).ready(function () {
        $('#ver').on('click',function(){
            $('#verDetalle').append('<p>Esto es una prueba</p>');

        });

     });
</script>

<?php
include_once '../estructura/footer.php';
?>