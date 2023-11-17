<?php
include_once '../../configuracion.php';
$Titulo = "Rols";
include_once '../estructura/headPrivado.php';


$objRol=new AbmRol();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idRol'])){
    $listaRol=$objRol->buscar($datos);
    if(count($listaRol)==1){
        $obj=$listaRol[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionRol.php" method="post">
            <label for="id" style="width:120px">ID Rol</label>
            <input type="number" name="idRol" id="idRol" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="descripcion" style="width:120px"> Rol</label>
            <input type="text" name="rodescripcion" id="rodescripcion" value="<?php echo($obj->getDescripcion()) ?>"><br>
 
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexRol.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");

?>