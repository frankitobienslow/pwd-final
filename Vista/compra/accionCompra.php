<?php
    include_once '../../configuracion.php';
    $Titulo = "Lista de Compras";
    include_once '../estructura/header.php';
    $hoja = "Compras";
    

    $resp=false; 
    $objCompra=new AbmCompra();
    $listaObj = $objCompra->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idcompra"] = intval($datos["idCompra"]);
            $datos["cofecha"] = intval($datos["fechaCompra"]); 
            $datos["idusuario"] = intval($datos["idUsuario"]);

            if($objCompra->modificacion($datos)){
                $resp=true; 
            }
        }

        
        if($datos['accion']=='Nuevo'){
            //echo("<br> nuevo");
            $datos["idCompra"] = intval($datos["idCompra"]);
            $datos["cofecha"] = intval($datos["fechaCompra"]); 
            $datos["idusuario"] = intval($datos["idUsuario"]);
            if($objCompra->alta($datos)){
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
<a href="indexCompra.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>