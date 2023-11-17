//Implementación carrito
document.addEventListener("DOMContentLoaded", function () {
    var botonesCarrito = document.querySelectorAll('.carrito');
    var cantCarrito = parseInt($("#cantCarrito").text());
    botonesCarrito.forEach(function (boton) {
        //console.log("hola");
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
                    success: function (response){
                        cantCarrito+=1;
                        $("#cantCarrito").text(cantCarrito);
                        console.log(idProducto);
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
        //console.log("hola");
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

