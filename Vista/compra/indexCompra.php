<?php
$Titulo = "Lista Compras";
include_once("../estructura/headerLibre.php");
$objAbmCompra = new AbmCompra();

$listaCompra = $objAbmCompra->buscar(null);
//var_dump($listaCompra);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Compra</h2>
  <h5 style="text-align: left; color:dodgerblue;">Compras Realizadas</h5>            
  <form action="editarCompra.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:20%">Id Compra</th>
            <th style="width:40%">Fecha</th>
            <th style="width:20%">Id Usuario</th>
            <th style="width:40%">Usuario</th>
        
        </tr>
        
            <?php if(count($listaCompra)>0){
                foreach($listaCompra as $Compra){?>
                    <tr>
                    <td> <?php echo($Compra->getidCompra()) ?></td>
                    <td> <?php echo($Compra->getfecha())?></td>
                    <td> <?php echo($Compra->getobjUsuario()->getidUsuario())?></td>
                    <td> <?php echo($Compra->getobjUsuario()->getnombreUsuario())?></td>
                    
                    <td><a href="editarCompra.php?idCompra=<?php echo($Compra->getidCompra()) ?>" class="btn btn-info">Editar</a></td>
                </tr>
                <?php    
                }// fin for 
            } ?>
    </table>
  </form>

</div>


<script src="../js/funciones.js"></script>
<?php
include_once("../estructura/footer.php");
?>
