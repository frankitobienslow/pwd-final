$(document).ready(function() {
    $('#registroForm').validate({
      rules: {
          usnombre: {
              required: true,
              alphanumeric: true
          },
          uspass: {
              required: true,
              alphanumeric: true
          },
          usmail: {
              required: true,
              email: true
          }
      },
      messages: {
          usnombre: {
              required: "Por favor ingresa tu nombre de usuario.",
              alphanumeric: "El nombre de usuario solo puede contener letras y números."
          },
          uspass: {
              required: "Por favor ingresa tu contraseña.",
              alphanumeric: "La contraseña solo puede contener letras y números."
          },
          usmail: {
              required: "Por favor ingresa tu correo electrónico.",
              email: "Por favor ingresa un correo electrónico válido."
          }
      },
      errorElement: 'div',
      errorPlacement: function(error, element) {
          // Agrega la clase 'is-invalid' a los elementos con error
          element.addClass('is-invalid');
          // Agrega el mensaje de error después del elemento
          error.insertAfter(element);
      },
      success: function(label, element) {
          // Remueve la clase 'is-invalid' y agrega 'is-valid' en elementos válidos
          $(element).removeClass('is-invalid').addClass('is-valid');
          // Remueve el mensaje de error si el campo es válido
          $(element).next('div.invalid-feedback').remove();
      },
      submitHandler: function(form) {
        form.submit();
      }
  });

  $('#loginForm').validate({
    rules: {
        usnombre: {
            required: true,
            alphanumeric: true
        },
        uspass: {
            required: true,
            alphanumeric: true
        },
    },
    messages: {
        usnombre: {
            required: "Por favor ingresa tu nombre de usuario.",
            alphanumeric: "El nombre de usuario solo puede contener letras y números."
        },
        uspass: {
            required: "Por favor ingresa tu contraseña.",
            alphanumeric: "La contraseña solo puede contener letras y números."
        },
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
        // Agrega la clase 'is-invalid' a los elementos con error
        element.addClass('is-invalid');
        // Agrega el mensaje de error después del elemento
        error.insertAfter(element);
    },
    success: function(label, element) {
        // Remueve la clase 'is-invalid' y agrega 'is-valid' en elementos válidos
        $(element).removeClass('is-invalid').addClass('is-valid');
        // Remueve el mensaje de error si el campo es válido
        $(element).next('div.invalid-feedback').remove();
    },
    submitHandler: function(form) {
      form.submit();
    }
});
});