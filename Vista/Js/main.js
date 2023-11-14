document.addEventListener("DOMContentLoaded", function () {
    var botonesCarrito = document.querySelectorAll('.carrito');

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
        // Aquí puedes almacenar el ID en un arreglo carrito o en una cookie, por ejemplo
        // Después, redireccionar a la página del carrito
        // Ejemplo de llamada AJAX (usando jQuery)
        $.ajax({
            url: '../carrito/agregar-al-carrito.php',
            method: 'POST',
            data: { idProducto: idProducto },
            success: function (response) {
                alert("Producto agregado al carrito")
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
});