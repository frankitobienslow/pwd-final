<?php
    include_once "../estructura/headLibre.php";
?>
<div class="container col-md-3">
    <div class="card p-2 m5">
  <h2 class="mt-5 mb-4 text-center">Formulario de Registro</h2>
  <form id="registroForm" action="accionLogin.php" method="post">
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="text" class="form-control" id="usnombre" name="usnombre" required>
    </div>
    <div class="form-group">
      <label for="contrasena">Contraseña:</label>
      <input type="password" class="form-control" id="uspass" name="uspass" required>
    </div>
    <div class="form-group">
      <label for="email">Correo Electrónico:</label>
      <input type="email" class="form-control" id="usmail" name="usmail" required>
    </div>
    <input type="text" hidden id="accion" name="accion" value="nuevo">
    <button type="submit" class="btn btn-primary btn-block mt-3">Enviar</button>
    <a href="indexLogin.php" class="btn btn-secondary mt-3">Átras</a>
  </form> 
  </div>
</div>

<!-- Agrega el script de validación con Bootstrap -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $(document).ready(function() {
    $('#registroForm').validate({
      rules: {
        nombre: 'required',
        contrasena: 'required',
        email: {
          required: true,
          email: true
        }
      },
      messages: {
        nombre: 'Por favor, ingresa tu nombre',
        contrasena: 'Por favor, ingresa tu contraseña',
        email: {
          required: 'Por favor, ingresa tu correo electrónico',
          email: 'Por favor, ingresa una dirección de correo electrónico válida'
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>
<?php  
include_once '../estructura/footer.php';
?>