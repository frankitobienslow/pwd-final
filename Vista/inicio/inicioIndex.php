<?php
include_once("../../configuracion.php");
$objSession=new Session();
if($objSession->validar()){
    include_once '../estructura/headPrivado.php';
    }else{
      include_once '../estructura/headLibre.php';
    }
?>
<title>Inicio | wesh wesh</title>
<a href="../grilla/indexGrilla.php"><div class="container imagenInicio">
    
</div></a>
<?php
include_once "../estructura/footer.php";
?>