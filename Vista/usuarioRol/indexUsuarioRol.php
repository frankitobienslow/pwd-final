<?php
$Titulo = "Lista Usuariorols";
include_once("../estructura/headerPrivado.php");
$objAbmUsuariorol = new AbmUsuariorol();

$listaUsuariorol = $objAbmUsuariorol->buscar(null);
//var_dump($listaUsuariorol);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla </h2>
  <h5 style="text-align: left; color:dodgerblue;">Usuariorols disponibles</h5>            
  <form action="editarUsuariorol.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id</th>
            <th style="width:40%">Id Usuariorol</th>
            <th style="width:20%">Fecha</th>
            <th style="width:20%">Id Usuario</th>
        
        </tr>
        
            <?php if(count($listaUsuariorol)>0){
                foreach($listaUsuariorol as $Usuariorol){?>
                    <tr>
                    <td> <?php echo($Usuariorol->getidUsuariorol()) ?></td>
                    <td> <?php echo($Usuariorol->getfecha())?></td>
                    <td> <?php echo($Usuariorol->getobjUsuario()->getidUsuario())?></td>
                    <td> <?php echo($Usuariorol->getobjUsuario()->getnombreUsuario())?></td>
                    
                    <td><a href="editarUsuariorol.php?idUsuariorol=<?php echo($Usuariorol->getidUsuariorol()) ?>" class="btn btn-info">Editar</a></td>
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
