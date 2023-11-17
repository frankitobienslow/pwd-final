<?php
$Titulo = "Lista Usuariorols";
include_once("../estructura/headPrivado.php");
$objAbmUsuariorol = new AbmUsuariorol();

$listaUsuariorol = $objAbmUsuariorol->buscar(null);
echo count($listaUsuariorol);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla </h2>
  <h5 style="text-align: left; color:dodgerblue;">Gestion de Roles</h5>            
  <form action="editarUsuariorol.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Nombre Usuario</th>
            <th style="width:40%">Roles</th>
        </tr>
        
            <?php if(count($listaUsuariorol)>0){
                foreach($listaUsuariorol as $Usuariorol){?>
                    <tr>
                    <td> <?php echo($Usuariorol->getObjUsuario()->getNombre()) ?></td>
                    <td> <?php echo($Usuariorol->getObjRol()->getDescripcion())?></td>
                    <td><a href="editarUsuarioRol.php?idusuario=<?php echo ($Usuariorol->getObjUsuario()->getId()) ?>&idrol=<?php echo ($Usuariorol->getObjRol()->getId()) ?>" class="btn btn-danger">Eliminar</a>
                    </td>
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
