<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/header.php';

$objAbmUsuario = new AbmUsuario();
$listaUsuario = $objAbmUsuario->buscar(null);
$objAbmRol = new AbmRol();
$listaRol = $objAbmRol->buscar(null);


$objUsuarioRol=new AbmUsuarioRol();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idusuario'])){
    $listaUsuarioRol = $objUsuarioRol->buscar($datos);
    if(count($listaUsuarioRol) == 1){
        $obj = $listaUsuarioRol[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionUsuarioRol.php" method="post">
            <label for="id" style="width:120px">Codigo Usuario</label>
            <input type="number" name="idusuario" id="idusuario" readonly value="<?php echo($obj->getObjUsuario()->getId()) ?>"><br>
            <label for="nombreUsuario" style="width:120px"> Usuario</label>
            <input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php echo($obj->getObjUsuario()->getNombre()) ?>"><br>
            <label for="idrol" style="width:120px"> Codigo Rol</label>
            <input type="text" name="idrol" id="idrol" value="<?php echo($obj->getObjRol()->getId()) ?>"><br>
            <label for="nombrerol" style="width:120px"> Rol</label>
            <input type="text" name="nombrerol" id="nombrerol" value="<?php echo($obj->getObjRol()->getNombre()) ?>"><br>
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexCompra.php" class="btn btn-secondary">Volver</a>
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