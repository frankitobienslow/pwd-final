<?php
$Titulo = "Lista Usuarios";
include_once("../estructura/header.php");
$objAbmUsuario = new AbmUsuario();

$listaUsuario = $objAbmUsuario->buscar(null);
//var_dump($listaUsuario);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Usuario</h2>
  <h5 style="text-align: left; color:dodgerblue;">Usuarios disponibles</h5>            
  <form action="editarUsuario.php" method="post">
    <table class="table-striped">
        <tr>
          <th style="width:10%">Id Usuario</th>
            <th style="width:10%">Nombre</th>
            <th style="width:20%">Mail</th>
            <th style="width:20%">Id Usuario</th>
            <th style="width:20%">Habilitado</th>
        
        </tr>
        
            <?php if(count($listaUsuario)>0){
                foreach($listaUsuario as $Usuario){
                  if ($Usuario->getDeshabilitado() === '0'){$check = "Habilitado";}
                    else{$check = "Deshabilitado";}?>
                    <tr>
                    <td> <?php echo($Usuario->getId()) ?></td>
                    <td> <?php echo($Usuario->getNombre())?></td>
                    <td> <?php echo($Usuario->getMail())?></td>
                    <td> <?php echo($check)?></td>
                    
                    <td><a href="editarUsuario.php?Id=<?php echo($Usuario->getidUsuario()) ?>" class="btn btn-info">Editar</a></td>
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
