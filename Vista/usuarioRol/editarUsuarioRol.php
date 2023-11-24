<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/headPrivado.php';
$data=data_submitted();
$objAbmUsuario = new AbmUsuario();
$objAbmUsuarioRol = new AbmUsuarioRol();
$objAbmRol = new AbmRol();
$listaObjRol = $objAbmRol->buscar(null);
$listaObjUsuario = $objAbmUsuario->buscar($data);
$objUsuario = $listaObjUsuario[0];
$listaObjUsuarioRol = $objAbmUsuarioRol->buscar($data);

//echo $listaObjUsuario[0]->getNombre();
//var_dump($listaObjUsuarioRol);

?>
<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla </h2>
  <h5 style="text-align: left; color:dodgerblue;">Gestion de Roles</h5>            
  <form action="editarUsuariorol.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Usuario: <?php echo($objUsuario->getNombre()); ?></th>
        </tr>

            <?php
              foreach ($listaObjRol as $objRol){  ?>
                <tr>
                
                <td><?php echo ($objRol->getDescripcion());?></td>
                <td><a href="./editarUsuarioRol.php?idusuario=<?php echo ($objRol->getId()); ?>" class="btn btn-info">Editar</a></td>

                </tr>
              <?php }
             ?>
    </table>
  </form>

<?php


?>