$(document).ready(function () {
    var producto;

    botonNuevo = $("#nuevoProducto");
    botonNuevo.click(function () {
        $('input[name="imagen"]').val('');
        $('#tituloModalProducto').text("Nuevo producto");
        $('#modalProducto').modal('show');
    })

    botonEditar = $(".editar");
    botonEditar.click(function () {
        producto = JSON.parse($(this).data('producto'));
        $('input[name="imagen"]').val('');
        $('#tituloModalProducto').text("Editar " + producto.pronombre + " (" + producto.idproducto + ")");
        $('.clickeable').each(function () {
            $(this).val(producto[$(this).attr("name")])
        })
        $('#modalProducto').modal('show');
    })


    botonEliminar = $(".eliminar");
    botonEliminar.click(function () {
        producto = $(this).data('producto')
        $('.eliminar-body').text("¿Deshabilitar " + producto.pronombre + " (" + producto.idproducto + ")?");
        $("#aceptarEliminar").attr('data-idproducto', producto.id); // Almacenar el ID del producto en el atributo data-idproducto del botón #aceptarEliminar
        $('#modalEliminar').modal('show');
    });

    $("#aceptarEliminar").click(function () {
        $.ajax({
            url: "accionProducto.php",
            type: "POST",
            data: { eliminar: producto.idproducto }, // Usar el ID del producto en la solicitud AJAX
            success: function (response) {
                console.log(response)
                if (response != 1) {
                    conflictos = JSON.parse(response);
                    $('.eliminar-body').text("Este producto está asociado a las siguientes compras en curso:");
                    var tablaHtml = '<table class="table table-striped table-hover"><thead><tr><th>ID Compra</th><th>Fecha de inicio</th><th>Estado</th></tr></thead><tbody>';
                    conflictos.forEach(function (compra) {
                        tablaHtml += '<tr>';
                        tablaHtml += '<td>' + compra.idcompra + '</td>';
                        tablaHtml += '<td>' + compra.cefechaini + '</td>';
                        tablaHtml += '<td>' + compra.compraestadotipo + '</td>';
                        tablaHtml += '</tr>';
                    });
                    tablaHtml += '</tbody></table>';
                    $('#modalEliminar').modal('hide');
                    $('.eliminar-body').append(tablaHtml);
                    $('.eliminar-body').append($("<span><b>Se cancelará el producto de las compras asociadas.</b> ¿Desea continuar?</span>"));
                    $('#modalEliminar2').modal('show');
                } else {
                    $('#modalEliminar').modal('hide');
                    $('#successModal').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#confirmarEliminar').click(function () {
        $.ajax({
            url: "accionProducto.php",
            type: "POST",
            data: {
                productoEliminar: producto.idproducto,
                comprasAsociadas: conflictos
            },
            success: function (response) {
                console.log(response);
                $('#modalEliminar2').modal('hide');
                if (response == 1) {
                    $('#successModal').modal('show');
                } else {
                    $('#errorModal').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    })

    botonHabilitar = $(".habilitar");
    botonHabilitar.click(function () {
        producto = $(this).data('producto');
        $('.habilitar-body').text("¿Habilitar " + producto.pronombre + " (" + producto.idproducto + ")?");
        $("#aceptarHabilitar").attr('data-idproducto', producto.id); // Almacenar el ID del producto en el atributo data-idproducto del botón #aceptarEliminar
        $('#modalHabilitar').modal('show');
    });

    $('#confirmarHabilitar').click(function () {
        $.ajax({
            url: "accionProducto.php",
            type: "POST",
            data: {
                habilitar: producto.idproducto,
            },
            success: function (response) {
                $('#modalHabilitar').modal('hide');
                if (response == "1") {
                    $('#successModal').modal('show');
                } else {
                    $('#errorModal').modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    })

    // Agregar reglas de validación a los campos del formulario
    $("#formProducto").validate({
        rules: {
            pronombre: {
                required: true
            },
            prodetalle: {
                required: true
            },
            proprecio: {
                required: true,
                min: 0
            },
            procantstock: {
                required: true,
                min: 1
            },
            imagen: {
                required: false
            }
        },
        messages: {
            pronombre: {
                required: "Por favor ingresa el nombre del producto."
            },
            prodetalle: {
                required: "Por favor ingresa el detalle del producto."
            },
            proprecio: {
                required: "Por favor ingresa el precio del producto.",
                min: "El precio debe ser mayor o igual a 0."
            },
            procantstock: {
                required: "Por favor ingresa el stock del producto.",
                min: "El stock debe ser mayor que 0."
            },
            imagen: {
                required: "Por favor selecciona una imagen para el producto."
            }
        }, errorPlacement: function (error, element) {
            // Muestra el mensaje de error debajo del elemento de entrada
            error.appendTo(element.parent());
        },
        errorClass: 'invalid-feedback' // Clase CSS para los mensajes de error
        ,
        highlight: function (element, errorClass, validClass) {
            // Agregar clase 'is-invalid' de Bootstrap al elemento
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            // Remover clase 'is-invalid' de Bootstrap al elemento
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {
            // Evitar que el formulario se envíe automáticamente
            //event.preventDefault();

            // Verificar si la variable 'producto' está definida
            var enviado = typeof producto !== 'undefined' ? producto.idproducto : "nuevo";
            $("#enviado").val(enviado);

            // Crear objeto FormData
            var formData = new FormData(form);

            // Recorrer todos los campos del formulario
            $(form).find('input').each(function () {
                // Agregar los valores de los campos al objeto FormData
                if ($(this).attr("name") == 'imagen' && $(this).val() == '') {
                    return true;
                }
                formData.append($(this).attr("name"), $(this).val());
            });

            // Enviar los datos del formulario mediante AJAX
            $.ajax({
                url: "accionProducto.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response)
                    $('#modalProducto').modal('hide');
                    if (response != "error") {
                        $('#successModal').modal('show');
                    } else {
                        $("#errorModal").modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });
    $('#errorModal').on('hidden.bs.modal', function () {
        location.reload();
    });
})

