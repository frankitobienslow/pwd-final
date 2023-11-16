<?php
    include_once '../../configuracion.php';
    $Titulo = "Lista de Productos";
    include_once '../estructura/header.php';
    

    $resp=false; 
    $objProducto=new AbmProducto();
    $listaObj = $objProducto->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $dato["idproducto"] = intval($datos["Id"]);
            $dato["pronombre"] = $datos["pronombre"]; 
            $dato["prodetalle"] = $datos["prodetalle"];
            $dato["stock"] = intval($datos["stock"]);
            
            if($objProducto->modificacion($dato)){
                $resp=true; 
            }// fin if 
        }// fin if

        if($datos['accion']=='Nuevo'){
            //echo("<br> nuevo");
            $dato["idProducto"] = intval($datos["Id"]);
            $dato["pronombre"] = $datos["pronombre"]; 
            $dato["prodetalle"] = $datos["prodetalle"];
            $dato["stock"] = floatval($datos["stock"]);
            if($objProducto->alta($dato)){
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
<a href="indexProducto.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>