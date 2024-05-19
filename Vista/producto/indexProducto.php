<?php
include_once "../estructura/headPrivado.php";
$objAbmProducto = new AbmProducto();
// Verificar el estado de los productos (Activos o Deshabilitados)
$estado = isset($_GET['estado']) ? $_GET['estado'] : 'activos';

if ($estado === 'activos') {
  $arregloProductos = $objAbmProducto->buscar(["habilitado" => 1]);
} elseif ($estado === 'deshabilitados') {
  $arregloProductos = $objAbmProducto->buscar(["habilitado" => 0]);
} else {
  // Manejo de un estado no válido, por ejemplo, mostrar todos los productos
  $arregloProductos = $objAbmProducto->buscar(null);
}

// Resto de tu código PHP y HTML para mostrar los productos
?>
<div class="container">
  <div class="row p-2">
    <div class="col col-sm-2">
      <h2>Productos</h2>
    </div>
    <div class="col">
      <button id="nuevoProducto" class="btn btn-success">Nuevo producto</button>
    </div>
    <nav style="font-weight:600">
      <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
          <a class="nav-link <?php echo $estado === 'activos' ? 'active' : ''; ?>" href="?estado=activos">Activos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $estado === 'deshabilitados' ? 'active' : ''; ?>" href="?estado=deshabilitados">Deshabilitados</a>
        </li>
      </ul>
    </nav>
    <table class="table rounded bg-light table-hover mt-2">
      <thead>
        <tr>
          <th>ID</th>
          <th class="text-center">Imagen</th>
          <th>Nombre</th>
          <th>Detalle</th>
          <th>Precio</th>
          <th>Stock</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($arregloProductos as $producto) {
          $datosProducto = [
            'idproducto' => $producto->getId(),
            'pronombre' => $producto->getNombre(),
            'prodetalle' => $producto->getDetalle(),
            'proprecio' => $producto->getPrecio(),
            'procantstock' => $producto->getStock(),
            'imagen' => $producto->getImagen()
          ];
        ?>
          <tr>
            <td class="fw-bold align-middle"><?php echo $producto->getId(); ?></td>
            <td class="text-center align-middle"> <img src="<?php echo $datosProducto["imagen"]; ?>" class="rounded" style="max-width:100px; max-height:50px"></td>
            <td class="align-middle"><?php echo $datosProducto["pronombre"]; ?></td>
            <td class="align-middle"><?php echo $datosProducto["prodetalle"]; ?></td>
            <td class="align-middle">$<?php echo $datosProducto["proprecio"]; ?></td>
            <td class="align-middle"><?php echo $datosProducto["procantstock"]; ?></td>
            </form>
            <td class="align-middle">
            <div class="btn-group" role="group" aria-label="Basic example">
                
                  <button class="btn btn-primary editar text-white d-flex justify-content-center align-items-center" data-producto='
          <?php echo json_encode($datosProducto); ?>' style="width:30px;height:30px">
                    <i class="bi bi-pencil-square"></i>
                  </button>
           
              
                  <?php if ($producto->getHabilitado() == 1) {
                  ?>
                    <button class="btn btn-danger eliminar text-white d-flex justify-content-center align-items-center" data-producto='<?php echo json_encode($datosProducto); ?>' style="width:30px;height:30px">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  <?php
                  } else {
                  ?>
                    <button class="btn btn-success habilitar text-white d-flex justify-content-center align-items-center" data-producto='<?php echo json_encode($datosProducto) ?>' style="width:30px;height:30px">
                      <i class="bi bi-plus-lg"></i>
                    </button>
                  <?php
                  } ?>
              
              </div>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="tituloModalProducto"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="form-group" action="accionProducto.php" method="POST" enctype="multipart/form-data" id="formProducto">
          <div class="modal-body">
            <input type="hidden" name="idproducto" id="enviado">
            <div class="mb-3">
              <label for="nombreProducto" class="form-label">Nombre</label>
              <input type="text" class="form-control clickeable" name="pronombre">
            </div>
            <div class="mb-3">
              <label for="detalleProducto" class="form-label">Detalle</label>
              <input type="text" class="form-control clickeable" name="prodetalle">
            </div>
            <div class="mb-3">
              <label for="precioProducto" class="form-label">Precio</label>
              <input type="number" class="form-control clickeable" name="proprecio" min="0">
            </div>
            <div class="mb-3">
              <label for="stockProducto" class="form-label">Stock</label>
              <input type="number" class="form-control clickeable" name="procantstock" min="0">
            </div>
            <div class="mb-3">
              <label for="imagenProducto" class="form-label">Imagen</label>

              <input type="file" class="form-control" name="imagen" accept="image/*">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="enviar">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Éxito</h5>
          <button type="button" style="color:white" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Los cambios se guardaron correctamente.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalHabilitar" tabindex="-1" aria-labelledby="habilitarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title eliminar-title">Habilitar producto</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body habilitar-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" id="confirmarHabilitar">Habilitar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Error</h5>
          <button type="button" style="color:white" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Lo sentimos, se ha producido un error.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title eliminar-title">Atención</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body eliminar-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger" id="aceptarEliminar">Deshabilitar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEliminar2" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title">Atención</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body eliminar-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="confirmarEliminar">Continuar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../Js/producto.js"></script>
  <?php
  include_once "../estructura/footer.php";
  ?>