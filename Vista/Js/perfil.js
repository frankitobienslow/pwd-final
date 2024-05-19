$(document).ready(function () {
    botonEditar = $("#editar");

    botonEditar.click(function () {
        $('#tituloModalEditar').text("Actualizar perfil");
        $.ajax({
            url: "accionUsuario.php",
            type: "POST",
            data: {
                accion: "obtenerClaves",
                idusuario: $(this).data("usuario")
            },
            success: function (response) {
                var claves = JSON.parse(response);
                console.log(claves)
                $('#modalEditar').modal("show");

                // Agregar reglas de validación a los campos del formulario
                $("#formEditar").validate({
                    rules: {
                        usnombre: {
                            required: true,
                            noRepetido: { claves: claves.nombres }, // Utilizar la regla personalizada para nombres
                            alphanumeric: true // Validar que solo contenga números y letras
                        },
                        usmail: {
                            required: true,
                            noRepetido: { claves: claves.mails }, // Utilizar la regla personalizada para mails
                            email: true // Validar formato de correo electrónico
                        },
                        confirmPassword: {
                            equalTo: "#passUsuario", // Verificar que coincida con la nueva contraseña
                            required: function (element) {
                                return $("#passUsuario").val().length > 0; // Requerir confirmación solo si se ingresó una nueva contraseña
                            }
                        }
                    },
                    messages: {
                        usnombre: {
                            required: "Por favor ingresa un nombre de usuario."
                        },
                        usmail: {
                            required: "Por favor ingresa tu dirección de correo electrónico."
                        },
                        confirmPassword: {
                            equalTo: "Las contraseñas no coinciden.",
                            required: "Por favor ingrese nuevamente la contraseña"
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.appendTo(element.parent());
                    },
                    errorClass: 'invalid-feedback',
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass("is-invalid");
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass("is-invalid");
                    },
                    submitHandler: function (form) {
                        // Crear objeto FormData
                        var formData = new FormData(form);
                        // Recorrer todos los campos del formulario
                        $(form).find('input').each(function () {
                            // Agregar los valores de los campos al objeto FormData
                            formData.append($(this).attr("name"), $(this).val());
                        });
                        formData.append("accion", "editarPerfil");
                        console.log(formData)

                        // Enviar los datos del formulario mediante AJAX
                        $.ajax({
                            url: "accionUsuario.php",
                            type: "POST",
                            data: formData,
                            processData: false,  // Evitar que jQuery procese los datos automáticamente
                            contentType: false,  // Evitar que jQuery establezca el tipo de contenido automáticamente
                            success: function (response) {
                                $('#modalEditar').modal('hide');
                                if (response == 1) {
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
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    $.validator.addMethod("noRepetido", function (value, element, params) {
        var claves = params.claves;
        // Verificar si el valor está en el array
        return $.inArray(value, claves) === -1;
    }, "Ya está en uso.");

    // Agregar regla personalizada para validar que el nombre de usuario contenga solo números y letras
    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[A-Za-z0-9]+$/.test(value);
    }, "El nombre de usuario solo puede contener números y letras.");

    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });
    $('#errorModal').on('hidden.bs.modal', function () {
        location.reload();
    });

});