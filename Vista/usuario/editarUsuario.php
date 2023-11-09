<?php
include_once '../../configuracion.php';
$Titulo = "Usuario";
include_once '../estructura/header.php';


$objUsuario=new AbmUsuario();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idusuario'])){
    $listaUsuario=$objUsuario->buscar($datos);
    if(count($listaUsuario)==1){
        $obj=$listaUsuario[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionUsuario.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="idUsuario" id="idUsuario" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="nombreUsuario" style="width:120px"> Usuario</label>
            <input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php echo($obj->getNombre()) ?>"><br>
            <label for="mail" style="width:120px"> mail</label>
            <input type="text" name="mail" id="mail" value="<?php echo($obj->getMail()) ?>"><br>
            <label for="Usuario" style="width:120px"> Id Usuario</label>
            <input type="radio" name="deshabilitado" id="deshabilitado"  <?php
             if ($Usuario->getDeshabilitado() === '0'){$check = "checked";}
                    else{$check = "";} echo($check);?>>
      
        
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexUsuario.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");
//      <input type="text" name="idUsuario" id="idUsuario" value="<?php echo($obj->getobjUsuario()->getidUsuario()) ? >">
//<input type="text" name="idTipo" id="idTipo" value="<?php echo($obj->getobjTipo()->getIdTipo()) ? >">
?>