<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/headPrivado.php';


$objUsuario=new AbmUsuario();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idusuario'])){
    echo $datos['idusuario'];
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
            <input type="number" name="idusuario" id="idusuario" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="nombreUsuario" style="width:120px">Usuario</label>
            <input type="text" name="usnombre" id="usnombre" value="<?php echo($obj->getNombre()) ?>"><br>
            <label for="mail" style="width:120px">Mail</label>
            <input type="text" name="usmail" id="usmail" value="<?php echo($obj->getMail()) ?>"><br>
            <label for="deshabilitado" style="width:120px">Deshabilitado</label>
            <input type="text" name="usdeshabilitado" id="usdeshabilitado" value="<?php echo($obj->getDeshabilitado()) ?>"><br>
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