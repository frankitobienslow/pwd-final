//Implementación carrito
document.addEventListener("DOMContentLoaded", function () {
    var botonesCarrito = document.querySelectorAll('.carrito');
    var cantCarrito = parseInt($("#cantCarrito").text());
    botonesCarrito.forEach(function (boton) {

        boton.addEventListener('click', function (event) {
            event.preventDefault();
            var idProducto = boton.getAttribute('data-id');
            // Llamar a una función para agregar el ID al carrito
            agregarAlCarrito(idProducto);
        });
    });

    function agregarAlCarrito(idProducto) {
        // Puedes hacer una llamada AJAX para enviar el ID del producto al servidor
        $.ajax({
            url: '../carrito/carrito.php',
            method: 'POST',
            data: { idProducto: idProducto },
            success: function (response) {
                // Actualizar el contenido de #cantCarrito
                $.ajax({
                    url: '../estructura/carritoIcono.php',
                    method: 'POST',
                    data: { cantCarrito: cantCarrito + 1 },
                    success: function (response) {
                        cantCarrito+=1;
                        $("#cantCarrito").text(cantCarrito);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                })
             
            },
            error: function (error) {
                alert("Producto no agregado")
            }
        });
    }
});

$(document).ready(function () {
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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

<<<<<<< HEAD
  //});
    
});

=======
    //});

    //Agregar al carrito
    var botonesCarrito = document.querySelectorAll('.carrito');
    tokens = [];
    var cantCarrito = parseInt($("#cantCarrito").text());

    botonesCarrito.forEach(function (boton) {

        boton.addEventListener('click', function (event) {
            var tiempoActual = new Date().getTime();
            // Verificar si el tiempo desde el último clic es menor que 5 milisegundos
            if (tokens.length !== 0 && tiempoActual - tokens[tokens.length - 1] < 5) {
                console.log("Duplicación evitada.");
                return;
            } else {
                event.preventDefault();
                tokens.push(tiempoActual);
                //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
                $.ajax({
                    url: '../carrito/agregarAlCarrito.php',
                    method: 'POST',
                    data: { idProducto: $(boton).data('id') },

                    success: function (response) {
                        cantCarrito += 1;
                        $("#cantCarrito").text(cantCarrito);
                        console.log($(boton).data('id'))
                    },
                    error: function (error) {
                        console.log("No se agregó al carrito")
                    }
                });
            }
        });
    });

    //Eliminar del carrito
    var botonesEliminar = document.querySelectorAll('.eliminarCarrito');
    botonesEliminar.forEach(function (boton) {

        boton.addEventListener('click', function (event) {
            var tiempoActual = new Date().getTime();
            // Verificar si el tiempo desde el último clic es menor que 5 milisegundos 
            if (tokens.length !== 0 && tiempoActual - tokens[tokens.length - 1] < 5) {
                console.log("Duplicación evitada.");
                return;
            } else {
                event.preventDefault();
                tokens.push(tiempoActual);
                //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
                $.ajax({
                    url: '../carrito/eliminarDelCarrito.php',
                    method: 'POST',
                    data: { idProducto: $(boton).data('id') },

                    success: function (response) {
                        var productos = document.querySelectorAll('.producto');
                        eliminarRender($(boton).data('id'), productos);
                    },
                    error: function (error) {
                        console.log("No se eliminó del carrito")
                    }
                });
            }
        });

    });
    //Eliminar visualmente
    function eliminarRender(id, productos) {
        if (cantCarrito > 0) {
            cantCarrito -= 1;
            $("#cantCarrito").text(cantCarrito);
        } else {
            $("#confirmarCompra").css("display", "none");
            console.log("Puuuto")
        }


        var cantProductos = productos.length;
        for (let i = 0; i < cantProductos; i++) {
            if ($(productos[i]).data('id') == id) {
                productos[i].style.display = "none";
                console.log(id);
            }
        }
    }
})
>>>>>>> c63ef4acd40110f73ae4136d0d6d05acbee856c1
