<?php
    $Titulo="Lista Compra Cliente y estado";
    include_once "../estructura/headPrivado.php";
    $objUsuario=$objSession->getUsuario();
    $objAbmCompraEstado=new AbmCompraEstado();
    $objAbmCompra=new AbmCompra();
    //$param["idcompraestadotipo"]=2;
    //$listaobjEstado= $objAbmCompraEstado->buscar(null);
    //var_dump($listaobjEstado);
    $dato["idusuario"]=$objUsuario->getId();
    $listaCompraCliente=$objAbmCompra->buscar($dato);
    for($i=0;$i<count($listaCompraCliente);$i++){
        $idcompra["idcompra"]=$listaCompraCliente[$i]->getId();
        $listaObjCompraEstado[$i]=$objAbmCompraEstado->buscar($idcompra);
    }
    
    //var_dump($listaCompraCliente);
    var_dump($listaObjCompraEstado);
?>
<div class="container mt-5">
    <table class="table table-hover  justify-content-center">
    <thead>
        <tr>
        <th scope="col">Número de Compra</th>
        <th scope="col">Detalles de la compra</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Larry the Bird</td>
        </tr>
    </tbody>
    </table>
</div>
<?php
    $Titulo="Lista Compra Cliente y estado";
    include_once "../estructura/footer.php";
?>