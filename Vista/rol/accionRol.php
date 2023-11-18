<?php
    include_once '../../configuracion.php';
  

    
    $resp=false; 
    $objRol=new AbmRol();
    $listaObj = $objRol->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idrol"] = intval($datos["idRol"]);
            $datos["rodescripcion"] = intval($datos["rodescripcion"]); 
            if($objRol->modificacion($datos)){
                $resp=true; 
            }
        }

        if($datos['accion']=='Borrar'){
            if($objRol->baja($datos)){
                $resp=true; 

            }// fin if 
        }

        if($datos['accion']=='Nuevo'){
            //echo("<br> nuevo");
            $datos["idrol"] = intval($datos["idRol"]);
            $datos["rodescripcion"] = intval($datos["rodescripcion"]); 
            if($objRol->alta($datos)){
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
<a href="indexRol.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>