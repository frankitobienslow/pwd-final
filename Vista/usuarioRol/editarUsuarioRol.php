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

?>
<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla </h2>
  <h5 style="text-align: left; color:dodgerblue;">Gestion de Roles</h5>            
  <form action="editarUsuariorol.php" method="post">
    <table class="table table-striped">
        <tr>
            <th style="width:10%">Usuario: <?php echo($objUsuario->getNombre()); ?></th>
        </tr>

            <?php
            $i=0;
              foreach ($listaObjRol as $objRol){  ?>
               
                <tr>               
                <td><?php echo ($objRol->getDescripcion());?></td>
                <td>
                  <?php
                    $rol = "rol".$objRol->getId();
                    $rol = '<input type="checkbox" id="'.$rol.'" name="'.$rol.'" value="'.$rol;
                    if ($objRol->getId() == $listaObjUsuarioRol[$i]->getObjRol()->getId()){
                  
                      $rol .= ' checked">';
                    }else{ $rol .= '">';}
                    echo $rol;
                  $i++;
                  ?>
                </td>

                </tr>
              <?php }
             ?>
    </table>
  </form>
  <td><a href="./accionUsuarioRol.php?idusuario=<?php echo ($objRol->getId()); ?>" class="btn btn-info">Guardar</a></td>
  <td><a href="./indexUsuarioRol.php" class="btn btn-info">Volver</a></td>
<?php


?>