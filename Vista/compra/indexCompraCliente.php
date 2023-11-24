<?php
    $Titulo="Lista Compra Cliente y estado";
    include_once "../estructura/headPrivado.php";
    $objUsuario=$objSession->getUsuario();
    $objAbmCompraEstado=new AbmCompraEstado();
    $objAbmCompra=new AbmCompra();
    //$param["idcompraestadotipo"]=2;
    //$listaobjEstado= $objAbmCompraEstado->buscar(null);
    //var_dump($listaobjEstado);
    $i=0;
    $dato["idusuario"]=$objUsuario->getId();
    $listaCompraCliente=$objAbmCompra->buscar($dato);
    for($i=0;$i<count($listaCompraCliente);$i++){
        $compra["idcompra"]=$listaCompraCliente[$i]->getId();
        $compra["cefechafin"]="IS NULL";
        $listaObjCompraEstado[$i]=$objAbmCompraEstado->buscar($compra);
    }
    
    //var_dump($listaCompraCliente);
    //var_dump($listaObjCompraEstado);



    /*foreach($listaCompraCliente as $unaCompra){
        $idCompra["idcompra"]=$unaCompra->getId();
        $listaObjCE=$objAbmCompraEstado->buscar($idCompra);
        $ultimoObjCE=count($listaObjCE);
        echo "<br>".$ultimoObjCE."<br>";
        $listaObjCECliente[$i]=$listaObjCE[$ultimoObjCE-1];

        //echo $listaObjCE[$i]->getFechaFin();
        $i++;
    }*/
    
?>
<div class="container mt-5">
    <table class="table table-hover  justify-content-center">
    <thead>
        <tr>
        <th scope="col">Número de Compra</th>
        <th scope="col">Detalles de la compra</th>
        <th scope="col">Estado de la compra</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($listaObjCompraEstado)>0){
            for($i=0;$i<count($listaObjCompraEstado);$i++){?>
                <tr>
                <th> <?php echo($listaObjCompraEstado[$i][0]->getObjCompra()->getId()) ?></th>
                <td><a href="verDetalles.php?idcompra=<?php echo($listaObjCompraEstado[$i][0]->getObjCompra()->getId()) ?>" class="btn btn-info">ver detalles</a></td>
                <td> <?php echo($listaObjCompraEstado[$i][0]->getObjCompraEstadoTipo()->getDescripcion())?></td>
                </tr>
            <?php }
            }else{?>
            <td colspan="3">
                <div class="alert alert-danger" role="alert">
                    Usted no tiene compras realizadas hasta el momento
                </div>
            </td>
            <?php } ?>
    </tbody>
    </table>
</div>
<?php
    include_once "../estructura/footer.php";
?>