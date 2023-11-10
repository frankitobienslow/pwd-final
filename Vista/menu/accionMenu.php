<?php
    include_once '../../configuracion.php';
    $Titulo = "Lista de Menu";
    include_once '../estructura/header.php';

    $resp=false; 
    $objMenu=new AbmMenu();
    $listaObj = $objMenu->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idmenu"] = intval($datos["id"]);
            $datos["menombre"] = $datos["nombreMenu"]; 
            $datos["medescripcion"] = intval($datos["descripcion"]);
            $datos["idpadre"] = floatval($datos["idpadre"]);
            $datos["deshabilitado"] = floatval($datos["deshabilitado"]);
            if($objMenu->modificacion($datos)){
                $resp=true; 
            }// fin if 
        }// fin if
        if($datos['accion']=='Borrar'){
            if($objMenu->baja($datos)){
                $resp=true; 

            }

        }// fin if 
        if($datos['accion']=='Nuevo'){
           
            $datos["idmenu"] = intval($datos["id"]);
            $datos["menombre"] = $datos["nombreMenu"]; 
            $datos["medescripcion"] = intval($datos["descripcion"]);
            $datos["idpadre"] = floatval($datos["idpadre"]);
            $datos["deshabilitado"] = floatval($datos["deshabilitado"]);
            if($objMenu->alta($datos)){
                $resp=true;
            }// fin if 

        }// fin if

        if($resp){
            $mensaje="La accion ".$datos['accion']."  se realizao correctamente " ;
        }
        else{
            //echo("mensaje error");
            $mensaje="Hubo un problema con la accion ".$datos['accion']." ";
            
        }

    }// fin if

    
?>

<div class="container">
    <?php
    echo($mensaje);
    ?>
</div>
<a href="indexMenu.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>