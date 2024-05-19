$(document).ready(function () {
    var rol;
    checks = $(".form-check-input");
    botonEditar = $(".editar");

    botonEditar.click(function () {
        rol = JSON.parse($(this).data('rol'));
        $('#tituloModalEditar').text("Editar Rol: " + rol.roldescripcion + " (" + rol.idrol + ")");
        $('.clickeable').each(function () {
            $(this).val(rol[$(this).attr("name")])
        })
        $.ajax({
            url: "accionRol.php",
            type: "POST",
            data: {
                accion: 'listarMenus',
                idrol: rol.idrol
            }, // Usar el ID del producto en la solicitud AJAX
            success: function (response) {
                listaMenuRol = JSON.parse(response);
                // Recorre cada checkbox
                checks.each(function () {
                    var checkbox = $(this);
                    var idmenu = checkbox.attr('name');

                    // Verifica si el idmenu está en listaMenuRol
                    var encontrado = false;
                    for (var i = 0; i < listaMenuRol.length; i++) {
                        if (listaMenuRol[i].idmenu == idmenu) {
                            encontrado = true;
                            break;
                        }
                    }

                    // Si se encuentra, marca el checkbox
                    if (encontrado) {
                        checkbox.prop('checked', true);
                    } else {
                        checkbox.prop('checked', false);
                    }
                });
                $('#modalEditar').modal('show');
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    })


    botonEliminar = $(".eliminar");
    botonEliminar.click(function () {
        rol = $(this).data('rol')
        console.log(rol)
        $('.eliminar-body').text("Deshabilitar " + rol.roldescripcion + " (" + rol.idrol + ")?");
        $("#aceptarEliminar").attr('data-rol', rol.idrol); // Almacenar el ID del producto en el atributo data-rol del botón #aceptarEliminar
        $('#modalEliminar').modal('show');
    });

    $("#aceptarEliminar").click(function () {
        $.ajax({
            url: "accionRol.php",
            type: "POST",
            data: { eliminar: rol.idrol }, // Usar el ID del producto en la solicitud AJAX
            success: function (response) {
                console.log(response)
                if (response != 1) {
                    $('#modalEliminar').modal('hide');
                    $('#errorModal').modal('show');
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

    botonHabilitar = $(".habilitar");
    botonHabilitar.click(function () {
        rol = $(this).data('rol');
        console.log(rol)
        $('.habilitar-body').text("¿Habilitar " + rol.roldescripcion + " (" + rol.idrol + ")?");
        $("#aceptarHabilitar").attr('data-idproducto', rol.id); // Almacenar el ID del producto en el atributo data-idproducto del botón #aceptarEliminar
        $('#modalHabilitar').modal('show');
    });

    $('#confirmarHabilitar').click(function () {
        $.ajax({
            url: "accionRol.php",
            type: "POST",
            data: {
                habilitar: rol.idrol,
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

    botonNuevo = $("#nuevo");
    botonNuevo.click(function () {
        $('.clickeable').each(function () {
            $(this).val('')
        })
        checks.each(function () {
            var checkbox = $(this);
            checkbox.prop('checked', false);
        });
        $("#enviado").val("nuevo");
        $('#tituloModalEditar').text("Nuevo Rol");
        $('#modalEditar').modal('show');
    })

    $.validator.addMethod("alphanumericWithSpaces", function(value, element) {
        return this.optional(element) || /^[A-Za-z\s]+$/.test(value);
    }, "El nombre del rol solo puede contener letras y espacios.");

    // Agregar reglas de validación a los campos del formulario
    $("#formEditar").validate({
        rules: {
            roldescripcion: {
                required: true,
                alphanumericWithSpaces:true
            }
        },
        messages: {
            roldescripcion: {
                required: "Por favor ingresa el nombre del rol.",
            },
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

            var enviado = typeof rol !== 'undefined' ? rol.idrol : "nuevo";
            $("#enviado").val(enviado);
            arrChecks = [];

            checks.each(function () {
                checkbox = $(this);
                nombre = $(this).attr('name');
                if (checkbox.prop('checked')) {
                    arrChecks.push(nombre);
                }
            })
            // Recorrer todos los campos del formulario

            // Enviar los datos del formulario mediante AJAX
            $.ajax({
                url: "accionRol.php",
                type: "POST",
                data: {
                    accion: "editar",
                    roldescripcion: $("#roldescripcion").val(),
                    idrol: $("#enviado").val(),
                    arrChecks: arrChecks,
                },
                success: function (response) {
                    console.log(response)
                    $('#modalEditar').modal('hide');
                    if (response == 'errorGestionRol') {
                        ;
                        $(".modal-body-error").text("No puedes desasignar el menú de gestión de roles al rol de administrador.")
                        $("#errorModal").modal('show');
                    } else {
                        $('#successModal').modal('show');
                    }

                },
                error: function (xhr, status, error) {
                    alert(response);
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

