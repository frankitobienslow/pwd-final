<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';
$datos=data_submitted();
$objCI=new AbmCompraItem();
$listaItemDeCompra=$objCI->buscar($datos); // devuelve un array de obj ite con el id compra dado
// objCI => obj compra item
$idcompra=$listaItemDeCompra[0]->getObjCompra()->getId();
if(isset($datos['idcompra'])){
  ?>
  <!--Tabla de productos pagados -->
    <div class="container mt-5">
    <h3> ID Compra: <?php echo($idcompra);?>
    <button class="btn btn-info mx-5 enviar" id="<?php echo($datos['idcompra']) ?>">Enviar Compra</button>
    </h3>
    <table class="table">
        <thead>
            <tr>
            <th scope="col" class="fs-4">Id Item</th>
            <th scope="col" class="fs-4">Nombre</th>
            <th scope="col" class="fs-4">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($listaItemDeCompra)>1){
                foreach($listaItemDeCompra as $unItem){
                ?>
                <tr>
                <th scope="row" class="fs-5"><?php echo($unItem->getId());?></th>
                <td class="fs-5"><?php echo($unItem->getObjProducto()->getNombre()); ?></td>
                <td class="fs-5"><?php echo($unItem->getCantidad()); ?></td>
                <td id="respuesta">
                
                <button class="btn btn-danger cancelar" id="<?php echo($unItem->getId())?>">Cancelar</button>
                </td>
                </tr>
                <?php
                }// fin for 
                
            }// fin if 
            else{
                ?>
                
            <div class="alert alert-danger">
                No hay productos para enviar. 
            </div>
            <?php

            } ?>

        </tbody>
</table>
<!--MODAL-->
<div class="modal fade bg-light" id="avisoCompra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLabel">Compra enviada</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        La compra se enviará al cliente en el proximo despacho.  
      </div>
      <div class="modal-footer">
        <button type="button" id="cierre" class="btn btn-outline-info" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</div>


<div class="container">
   <button type="button" class="btn btn-info"><a href="indexCompraDeposito.php" class="fw-bolder">Volver</a></button> 
</div>
  <?php  

}// fin if
else{
    echo("Algo salio mal");
}// fin else
?>

<script>
    $(document).ready(function(){
        let botonesCancelar=$(".cancelar");
        //console.log(botonesCancelar);
        for (let i=0;i<botonesCancelar.length;i++){
            let boton=botonesCancelar[i];
                boton.addEventListener('click',function(e){
                e.preventDefault();
                let iditem=this.getAttribute('id');
                //console.log(iditem);
                $.ajax({
                    url:'accionCompraEnviada.php',
                    method:'POST',
                    data:{idcompraitem:iditem},
                    success:function(r){
                    console.log(r);
                    let par = document.createElement("span");
                    par.className="text-danger";
                    const text=document.createTextNode("Producto Cancelado");
                    par.appendChild(text);
                    const padre=boton.parentElement;
                    padre.appendChild(par);
                    boton.remove();

                    //innerHTML='<span class="text-danger">Producto Cancelado</span>';            
                    }
                });
            });

        }// fin for 

        // Llamado al idcompra 
        $('.enviar').on('click',function(){
            let compra=this.getAttribute('id');
            $.ajax({
                url:'accionCompraEnviada.php',
                method:'POST',
                data:{idcompra:compra},
                success:function(r){
                    //console.log(r);
                    $('#avisoCompra').modal('show');
                    $('#cierre').on('click',function(){
                        location.href='indexCompraDeposito.php';
                    });

                }// fin function

            });
        });

    });
</script>

<?php
include_once '../estructura/footer.php';
?>