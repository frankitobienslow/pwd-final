$(document).ready(function () {

    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })();

    // Pasa el password a un valor hash
    //$("#enviar").on("click",function(){
    //let password = $('#password').val();
    //console.log(md5(password));
    //});

    //Código para que mantenga el contador siempre visible hasta cuando se recargue la página
    $.ajax({
        url: '../carrito/accionCarrito.php',
        //Se le indica al servidor que se quiere actualizar el ícono
        data: { actualizarIcono: '' },
        method: 'POST',
        success: function (cantCarrito) {
            $("#cantCarrito").text(cantCarrito);
        },
    });

    //Agregar al carrito
    //Código para que no deje agregar un producto al carrio mas de una vez hasta cuando se recargue la página
    var botonesCarrito = document.querySelectorAll('.carrito');
    $.ajax({
        url: '../carrito/accionCarrito.php',
        method: 'POST',
        data: { obtenerCarrito: '' },
        success: function (arreglo) {
            productos = arreglo.productos;
            cantProductos = productos.length;
            botonesCarrito.forEach(function (boton) {
                var idBoton = $(boton).data('id');
                for (let i = 0; i < cantProductos; i++) {
                    if (productos[i].id == idBoton) {
                        botonIrAlCarrito = $('<a href="../carrito/carrito.php" class="btn btn-info">Ir al carrito</a>');
                        $(boton).replaceWith(botonIrAlCarrito);
                    }
                }
            });
        }
    })

    botonesCarrito.forEach(function (boton) {
        let id = $(boton).data('id');

        boton.addEventListener('click', function (event) {

            event.preventDefault();
            //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST

            $.ajax({
                url: '../carrito/accionCarrito.php',
                method: 'POST',
                data: { idAgregar: id },
                success: function (cantCarrito) {
 //                   console.log(id)
                    $("#cantCarrito").text(cantCarrito);
                    botonIrAlCarrito = $('<a href="../carrito/carrito.php" class="btn btn-info">Ir al carrito</a>');
                    $(boton).replaceWith(botonIrAlCarrito);
                },
                error: function (error) {
   //                 console.log("No se agregó al carrito")
                }
            });
        });


    });



    function renderizarProductos() {
        $.ajax({
            url: '../carrito/accionCarrito.php',
            method: 'POST',
            data: { obtenerCarrito: '' },
            success: function (arreglo) {
                productos = arreglo.productos;
                tabla = $("#tablaProductos");
                // Limpiar la tabla antes de renderizarla nuevamente
                tabla.find('.producto').remove();
                arregloCantidades = [];
                // Iterar sobre los productos y agregar filas a la tabla
                productos.forEach(function (producto) {
                    // Clonar la fila de producto y modificar los valores
                    var filaProducto = $('<tr class="producto">' +
                        '<td style="border:2px solid dodgerblue;" class="nombre"></td>' +
                        '<td style="border: 2px solid dodgerblue; text-align:center" class="detalle"></td>' +
                        '<td style="border:2px solid dodgerblue;" class="cantidad"><input class="form-control mx-auto" style="width:60px;" onkeydown="return false" type="number" min="1" step="1" value="1"></input></td>' +
                        '<td style="border:2px solid dodgerblue;" class="stock"></td>' +
                        '<td style="border:2px solid dodgerblue;" class="precio"></td>' +
                        '<td><i class="btn btn-danger bi bi-x p-1 m-1 eliminar"></i></td>' +
                        '</tr>');
                    filaProducto.find('.nombre').text(producto.nombre);
                    filaProducto.find('.detalle').text(producto.detalle);
                    var inputCantidad = filaProducto.find('.cantidad input');
                    inputCantidad.attr('max', producto.stock);
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

                botonConfirmar = $("<button class='btn btn-success mt-2' action='../carrito/accionCarrito.php' id='confirmarCompra'>Confirmar compra</button>");
                $("#tablaContainer").append(botonConfirmar);
                botonConfirmar.click(function (event) {
                    event.preventDefault();
                    // Capturar los valores de los inputs de cantidad
                    var cantidades = [];
                    $(".producto .cantidad input").each(function () {
                        var cantidad = $(this).val();
                        cantidades.push({
                            id: $(this).closest('.producto').attr('name'),
                            cantidad: cantidad
                        });
                    });
                    // Ahora en el array "cantidades" tendrás los pares id y cantidad para cada producto
                    $.ajax({
                        url: '../carrito/gestionCompra.php',
                        method: 'POST',
                        data: { enviarCantidades: cantidades,vaciar:'si'},
                        success: function () {
                            $('#exampleModal').modal('show');
                            $("#cerrarModal").on('click',function(){
                                location.href='../grilla/indexGrilla.php?logeado=si';
                            });
                            //console.log(r);
                        }
                    });
                });

            }
        });
    }
    renderizarProductos()

    //Eliminar del carrito
    function eliminarDelCarrito(id) {
        //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
        $.ajax({
            url: '../carrito/accionCarrito.php',
            method: 'POST',
            data: { idEliminar: id },
            success: function (cantCarrito) {
                console.log(id);
                $("#cantCarrito").text(cantCarrito);
                $("#producto-" + id).remove();
            },
            error: function (error) {
                console.log("No se eliminó del carrito")
            }
        });
    };

})