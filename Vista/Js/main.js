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


    //});

});


//Agregar al carrito
if (window.location.href.indexOf('http://localhost/PWD_2023_TPFINAL/Vista/grilla/indexGrilla.php') > -1) {
    var botonesCarrito = document.querySelectorAll('.carrito');
    tokens = [];
    var cantCarrito = parseInt($("#cantCarrito").text());
    botonesCarrito.forEach(function (boton) {

        boton.addEventListener('click', function (event) {
                event.preventDefault();
                //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
                $.ajax({
                    url: '../carrito/agregarAlCarrito.php',
                    method: 'POST',
                    data: { idProducto: $(boton).data('id') },

                    success: function (response) {
                        console.log($(boton).data('id'))
                        $("#prueba").html(response);
                        //cantCarrito += 1;
                        //
                       actualizarIcono();
                    },
                    error: function (error) {
                        console.log("No se agregó al carrito")
                    }
                });
        });
    });
    function actualizarIcono(){
        obtener={
           accion: 'cant'
        }
       /* $.ajax({
            url: "../carrito/agregarAlCarrito.php",
            type: "POST",
            data: JSON.stringify(obtener),
            success: function (response) {
                console.log(response)
                $("#cantCarrito").text(response);
            },
            error: function (error) {
                console.log("No se agregó al carrito")
                console.log(error)
            }
          })
        */}
}

if (window.location.href.indexOf('http://localhost/PWD_2023_TPFINAL/Vista/carrito/carrito.php') > -1) {
    
    //Eliminar del carrito
    var botonesEliminar = document.querySelectorAll('.eliminarCarrito');
    botonesEliminar.forEach(function (boton) {
   
        boton.addEventListener('click', function (event) {
             event.preventDefault();
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
            //}
        });

    });
    //Eliminar visualmente
    function eliminarRender(id, productos) {
        if (cantCarrito > 0) {
            cantCarrito -= 1;
            $("#cantCarrito").text(cantCarrito);
        } else {
            //$("#confirmarCompra").css("display", "none");
            console.log("Producto eliminado")
        }


        var cantProductos = productos.length;
        for (let i = 0; i < cantProductos; i++) {
            if ($(productos[i]).data('id') == id) {
                productos[i].style.display = "none";
                console.log(id);
            }
        }
    }
}


