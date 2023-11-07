<?php
$Titulo = "Lista Productos";
include_once("../estructura/header.php");
$objAbmProducto = new AbmProducto();

$listaProducto = $objAbmProducto->buscar(null);

?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Producto</h2>
  <h5 style="text-align: left; color:dodgerblue;">Productos disponibles</h5>            
  <form action="editarProducto.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:20%">Id Producto</th>
            <th style="width:40%">Nombre</th>
            <th style="width:40%">Detalle</th>
            <th style="width:10%">Stock</th>
        
        </tr>
        
            <?php if(count($listaProducto)>0){
                foreach($listaProducto as $Producto){?>
                    <tr>
                    <td> <?php echo($Producto->getId()) ?></td>
                    <td> <?php echo($Producto->getNombre())?></td>
                    <td> <?php echo($Producto->getDetalle())?></td>
                    <td> <?php echo($Producto->getStock())?></td>
                    
                    <td><a href="editarProducto.php?Id=<?php echo($Producto->getId()) ?>" class="btn btn-info">Editar</a></td>
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
