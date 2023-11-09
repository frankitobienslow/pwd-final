<?php
$Titulo = "Lista Menu";
include_once("../estructura/header.php");
$objAbmMenu = new AbmMenu();

$listaMenu = $objAbmMenu->buscar(null);
//var_dump($listaMenu);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Menu</h2>
  <h5 style="text-align: left; color:dodgerblue;">Menu disponibles</h5>            
  <form action="editarCompra.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id</th>
            <th style="width:40%">Nombre</th>
            <th style="width:20%">Descripcion</th>
            <th style="width:20%">Id Padre</th>
            <th style="width:20%">Habilitado</th>
        
        </tr>
        
            <?php if(count($listaMenu)>0){
                foreach($listaMenu as $Menu){?>
                    <tr>
                    <td> <?php echo($Menu->getId()) ?></td>
                    <td> <?php echo($Menu->getNombre())?></td>
                    <td> <?php echo($Menu->getDescripcion())?></td>
                    <td> <?php echo($Menu->getObjMenu()->getId())?></td>
                    <td> <?php echo($Menu->getObjMenu()->getNombre())?></td>
                    <td> <?php echo($Menu->getDeshabilitado())?></td>
                    
                    <td><a href="editarCompra.php?id=<?php echo($Menu->getId()) ?>" class="btn btn-info">Editar</a></td>
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
