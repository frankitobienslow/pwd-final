<?php
include_once '../../configuracion.php';
$Titulo = "Usuario Rol";
include_once '../estructura/header.php';

$objAbmUsuario = new AbmUsuario();
$listaUsuario = $objAbmUsuario->buscar(null);
$objAbmRol = new AbmRol();
$listaRol = $objAbmRol->buscar(null);


$objUsuarioRol=new AbmUsuarioRol();
$datos=data_submitted();
$obj=null; 
if(isset($datos['id'])){
    $listaUsuarioRol=$objUsuarioRol->buscar($datos);
    if(count($listaUsuarioRol)==1){
        $obj=$listaUsuarioRol[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionUsuarioRol.php" method="post">
            <label for="id" style="width:120px">Usuario</label>
            <input type="number" name="idusuario" id="idusuario" readonly value="<?php echo($obj->getObjUsuario()->getId()) ?>"><br>
            <input type="number" name="idUsuarioNombre" id="idUsuarioNombre" readonly value="<?php echo($obj->getObjUsuario()->getId()) ?>"><br>
            <label for="nombreRol" style="width:120px"> Rol</label>
            <input type="text" name="niddol" id="idol" value="<?php echo($obj->getObjRol()->getId()) ?>"><br>
            <input type="text" name="nombreRol" id="nombreRol" value="<?php echo($obj->getObjRol()->getId()) ?>"><br>

            <select id="idrol" name="idrol">
                <option value="<?php echo($obj->getObjRol()->getId()) ?>"><?php echo($obj->getObjRol()->getId()) ?></option>
                <?php foreach($listaRol as $rol){?>
                    <option value="<?php echo($tipo->getId()) ?>"> <?php echo ($tipo->getNombre()); ?></option>
                    <?php } ?>      
                </select><br>
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexUsuarioRol.php" class="btn btn-secondary">Volver</a>
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