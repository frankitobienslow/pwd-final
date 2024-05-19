$(document).ready(function () {
    carritoHabilitado();
    var botonesCarrito = document.querySelectorAll('.carrito');
    botonesCarrito.forEach(function (boton) {
        let id = $(boton).data('id');
        boton.addEventListener('click', function (event) {
            event.preventDefault();
            //AJAX para enviar el id del producto seleccionado a carrito.php con metodo POST
            $.ajax({
                url: './accionGrilla.php',
                method: 'POST',
                data: { idAgregar: id },
                success: function (response) {
                    $("#alerta").text(response);
                    $("#alerta").fadeIn().delay(2000).fadeOut(); // Mostrar la alerta con animación y luego ocultarla después de 2 segundos
                    carritoHabilitado();
                },
                error: function (error) {
                    //console.log(error)
                }
            });
        });
    });
    function carritoHabilitado() {
        $.ajax({
            url: './accionGrilla.php',
            method: 'POST',
            data: { accion: "carritoHabilitado" },
            success: function (response) {
                if (response == 0) {
                    $("#botonCarrito").addClass("disabled"); // Agregar clase de estilo para indicar deshabilitado
                }else {
                    $("#botonCarrito").removeClass("disabled"); // Agregar clase de estilo para indicar deshabilitado
                }
            },
            error: function (error) {
                // Manejar errores si es necesario
            }
        });
    }
})