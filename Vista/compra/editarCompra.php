<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/header.php';

$objAbmUsuario = new AbmUsuario();
$listaUsuario = $objAbmUsuario->buscar(null);


$objCompra=new AbmCompra();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idCompra'])){
    $listaCompras=$objCompra->buscar($datos);
    if(count($listaCompras)==1){
        $obj=$listaCompras[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionCompra.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="idCompra" id="idCompra" readonly value="<?php echo($obj->getidCompra()) ?>"><br>
            <label for="fecha" style="width:120px"> Compra</label>
            <input type="text" name="fecha" id="fechaCompra" value="<?php echo($obj->getfechaCompra()) ?>"><br>
            <label for="nombreUsuario" style="width:120px"> Nombre Usuario</label>
      
            <select id="idUsuario" name="idUsuario">
                <option value="<?php echo($obj->getobjUsuario()->getidUsuario())?>"><?php echo($obj->getobjUsuario()->getnombreUsuario()) ?></option>
                <?php foreach($listaUsuario as $Usuario){?>
                    <option value="<?php echo($Usuario->getIdUsuario()) ?>"> <?php echo ($Usuario->getnombreUsuario()); ?></option>
                    <?php } ?>      
                </select><br>
            <label for="Tipo" style="width:120px"> Id Tipo </label>

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