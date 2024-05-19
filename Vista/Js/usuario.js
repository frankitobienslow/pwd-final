$(document).ready(function () {
    var usuario;
    checks = $(".form-check-input");
    botonEditar = $(".editar");

    botonEditar.click(function () {
        usuario = JSON.parse($(this).data('usuario'));
        $("#enviado").val(usuario.idusuario);
        $('#tituloModalEditar').text("Editar usuario: " + usuario.usnombre + " (" + usuario.idusuario + ")");
        $('.clickeable').each(function () {
            $(this).val(usuario[$(this).attr("name")])
        })
        $.ajax({
            url: "accionUsuario.php",
            type: "POST",
            data: {
                accion: 'listarRoles',
                idusuario: usuario.idusuario
            }, // Usar el ID del producto en la solicitud AJAX
            success: function (response) {
                console.log(response)
                listaRoles = JSON.parse(response);

                // Recorre cada checkbox
                checks.each(function () {
                    var checkbox = $(this);
                    var idrol = checkbox.attr('name');

                    // Verifica si el idmenu está en listaMenuRol
                    var encontrado = false;
                    for (var i = 0; i < listaRoles.length; i++) {
                        if (listaRoles[i].idrol == idrol) {
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
        usuario = $(this).data('usuario')
        $('.eliminar-body').text("Deshabilitar " + usuario.usnombre + " (" + usuario.idusuario + ")?");
        $("#aceptarEliminar").attr('data-usuario', usuario.idusuario); // Almacenar el ID del producto en el atributo data-usuario del botón #aceptarEliminar
        $('#modalEliminar').modal('show');
    });

    $("#aceptarEliminar").click(function () {
        $.ajax({
            url: "accionUsuario.php",
            type: "POST",
            data: { eliminar: usuario.idusuario }, // Usar el ID del producto en la solicitud AJAX
            success: function (response) {
                console.log(response)
                $('#modalEliminar').modal('hide');
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
    });

    botonHabilitar = $(".habilitar");
    botonHabilitar.click(function () {
        usuario = $(this).data('usuario');
        $('.habilitar-body').text("¿Habilitar " + usuario.usnombre + " (" + usuario.idusuario + ")?");
        $('#modalHabilitar').modal('show');
    });

    $('#confirmarHabilitar').click(function () {
        $.ajax({
            url: "accionUsuario.php",
            type: "POST",
            data: {
                habilitar: usuario.idusuario,
            },
            success: function (response) {
                $('#modalHabilitar').modal('hide');
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

    // Agregar reglas de validación a los campos del formulario
    $("#formEditar").validate({
        submitHandler: function (form) {
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
                url: "accionUsuario.php",
                type: "POST",
                data: {
                    accion: "editar",
                    idusuario: $("#enviado").val(),
                    arrChecks: arrChecks,
                },
                success: function (response) {
                    console.log(response)
                    $('#modalEditar').modal('hide');
                    if (response != "true") {
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

