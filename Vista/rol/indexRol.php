<?php
$Titulo = "Lista Rols";
include_once("../estructura/headPrivado.php");
$objAbmRol = new AbmRol();

$listaRol = $objAbmRol->buscar(null);

?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Rol</h2>
  <h5 style="text-align: left; color:dodgerblue;">Rols disponibles</h5>            
  <form action="editarRol.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id Rol</th>
            <th style="width:40%">Descripcion</th>
        
        </tr>
        
            <?php if(count($listaRol)>0){
                foreach($listaRol as $Rol){?>
                    <tr>
                    <td> <?php echo($Rol->getId()) ?></td>
                    <td> <?php echo($Rol->getDescripcion())?></td>
                   
                    <td><a href="editarRol.php?idRol=<?php echo($Rol->getId()) ?>" class="btn btn-info">Editar</a></td>
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
