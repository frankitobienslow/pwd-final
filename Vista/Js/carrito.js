$(document).ready(function () {
    function renderizarProductos() {
        $.ajax({
            url: '../carrito/accionCarrito.php',
            method: 'POST',
            data: { obtenerCarrito: '' },
            success: function (arreglo) {
                if (arreglo.length != 0) {
                    productos = arreglo.productos;
                    tabla = $("#tablaProductos");
                    // Limpiar la tabla antes de renderizarla nuevamente
                    tabla.find('.producto').remove();
                    arregloCantidades = [];
                    // Iterar sobre los productos y agregar filas a la tabla
                    productos.forEach(function (producto) {
                        // Clonar la fila de producto y modificar los valores
                        var filaProducto = $('<tr class="align-middle producto">' +
                            '<td class="align-middle imagen"><img src="' + producto.imagen + '" class="rounded" style="max-width:100px; max-height:60px"></img></td>' +
                            '<td class="align-middle nombre"></td>' +
                            '<td class="align-middle detalle"></td>');
                        var inputCantidad = $('<td class="align-middle cantidad"><input class="align-middle form-control mx-auto" style="width:60px;" onkeydown="return false" type="number" min="1" step="1"></input></td>');
                        inputCantidad.attr('max', producto.stock);
                        inputCantidad.find('input').val(producto.cantidad);
                        filaProducto.append(inputCantidad);
                        filaProducto.append($(
                            '<td class="align-middle stock"></td>' +
                            '<td class="align-middle precio"></td>' +
                            '<td><button class="align-middle btn btn-close eliminar"></button></td>' +
                            '</tr>'));
                        filaProducto.find('.nombre').text(producto.nombre);
                        filaProducto.find('.detalle').text(producto.detalle);
                        filaProducto.find('.stock').text(producto.stock);
                        filaProducto.find('.precio').text('$' + producto.precio);
                        filaProducto.attr('id', 'producto-' + producto.id);
                        filaProducto.attr('name', producto.id);
                        filaProducto.find('.eliminar').click(function (event) {
                            event.preventDefault();
                            eliminarDelCarrito(producto.id);
                        });
                        // Agregar la fila a la tabla
                        tabla.append(filaProducto);
                    });
                    // Verificar si hay productos en el carrito antes de mostrar el botón
                    botonConfirmar = $("<button type='button' data-toggle='modal' data-target='#modal' class='btn btn-success mt-2' action='../carrito/accionCarrito.php' id='confirmarCompra'>Confirmar compra</button>");
                    $("#tablaContainer").append(botonConfirmar);
                    botonConfirmar.click(function (event) {
                        event.preventDefault();
                        // Capturar los valores de los inputs de cantidad
                        var cantidades = [];
                        $(".producto .cantidad input").each(function () {
                            var cantidad = $(this).val();
                            cantidades.push({
                                idproducto: $(this).closest('.producto').attr('name'),
                                cicantidad: cantidad
                            });
                        });
                        // Ahora en el array "cantidades" tendrás los pares id y cantidad para cada producto
                        $.ajax({
                            url: '../carrito/accionCarrito.php',
                            method: 'POST',
                            data: { confirmarCompra: cantidades },
                            success: function (response) {
                                if (response == "Se produjo un error al procesar la compra, no contamos con stock para los productos solicitados.") {
                                    $('#modalError').modal('show');
                                    $('.modal-header h5').text("Error")
                                    $('.modal-body').text(response);
                                    $('#modalError').on('hidden.bs.modal', function () {
                                        window.location.reload();
                                    });
                                } else {
                                    $('#modalSuccess').modal('show');
                                    $('.modal-header h5').text("Compra realizada")
                                    $('.modal-body').text(response);
                                    $('#modalSuccess').on('hidden.bs.modal', function () {
                                        window.location.href = '../grilla/indexGrilla.php';
                                    });
                                }
                            }
                        });
                    });
                } else {
                    $('#modalInfo').modal('show');
                    $('.modal-header h5').text("Carrito vacío")
                    $('.modal-body').text("¡El carrito está vacío!");
                    $('#modalInfo').on('hidden.bs.modal', function () {
                        window.location.href = '../grilla/indexGrilla.php';
                    });
                }
            }
        });
    }

    renderizarProductos();

    //Eliminar del carrito
    function eliminarDelCarrito(id) {
        //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
        $.ajax({
            url: '../carrito/accionCarrito.php',
            method: 'POST',
            data: { idEliminar: id },
            success: function (response) {
                $("#producto-" + id).remove();
                if (response == "El carrito está vacío.") {
                    $('#modalInfo').modal('show');
                    $('.modal-header h5').text("Carrito vacío")
                    $('.modal-body').text("¡El carrito está vacío!");
                    $('#modalInfo').on('hidden.bs.modal', function () {
                        window.location.href = '../grilla/indexGrilla.php';
                    });
                }
            },
            error: function (error) {
                console.log("No se eliminó del carrito")
            }
        });
    };


})