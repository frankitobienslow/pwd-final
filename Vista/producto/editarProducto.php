<?php
include_once '../../configuracion.php';
$Titulo = "Productos";
include_once '../estructura/headPrivado.php';


$objProducto=new AbmProducto();
$datos=data_submitted();
$obj=null; 
if(isset($datos['Id'])){
    $listaProducto=$objProducto->buscar($datos);
    if(count($listaProducto)==1){
        $obj=$listaProducto[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionProducto.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="Id" id="Id" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="pronombre" style="width:120px"> Producto</label>
            <input type="text" name="pronombre" id="pronombre" value="<?php echo($obj->getNombre()) ?>"><br>
            <label for="detalle" style="width:120px"> Detalle</label>
            <input type="text" name="prodetalle" id="prodetalle" value="<?php echo($obj->getDetalle()) ?>"><br>
            <label for="stock" style="width:120px"> Stock</label>
            <input type="text" name="prostock" id="prostock" value="<?php echo($obj->getStock()) ?>"><br>
            
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexProducto.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");

?>