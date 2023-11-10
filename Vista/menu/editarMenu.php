<?php
include_once '../../configuracion.php';
$Titulo = "Menu";
include_once '../estructura/header.php';

$objAbmMenuP = new AbmMenu();
$listaMenuP = $objAbmMenuP->buscar(null);


$objMenu=new AbmMenu();
$datos=data_submitted();
$obj=null; 
if(isset($datos['id'])){
    $listaMenu=$objMenu->buscar($datos);
    if(count($listaMenu)==1){
        $obj=$listaMenu[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionMenu.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="idmenu" id="idmenu" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="nombreMenu" style="width:120px"> Menu</label>
            <input type="text" name="nombreMenu" id="nombreMenu" value="<?php echo($obj->getNombre()) ?>"><br>
            <label for="descripcion" style="width:120px"> Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" value="<?php echo($obj->getDescripcion()) ?>"><br>
            <label for="idpadre" style="width:120px"> Menu Padre</label>
      
            <select id="idpadre" name="idpadre">
                <option value="<?php echo($obj->getObjMenu()->getId())?>"><?php echo($obj->getObjMenu()->getNombre()) ?></option>
                <?php foreach($listaMenuP as $menuP){?>
                    <option value="<?php echo($menuP->getId()) ?>"> <?php echo ($menuP->getNombre()); ?></option>
                    <?php } ?>      
                </select><br>

            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexMenu.php" class="btn btn-secondary">Volver</a>
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