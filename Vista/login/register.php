<?php
include_once "../estructura/headLibre.php";
?>
<title>Registrarse | wesh wesh</title>
<div class="container p-5 col-md-4">
  <div class="card p-3">
    <h2 class="text-center">Registrarse</h2>
    <form id="registroForm" action="accionLogin.php" method="post" class="needs-validation">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" placeholder="Ingrese un nombre de usuario" class="form-control" id="usnombre" name="usnombre" required>
        <?php
        if ($_GET) {
          if (strpos($_GET["error"], "2") !== false) {
            $error_message = "El nombre de usuario ingresado ya está registrado.";
            echo "<span class='text-danger' style='font-size:14px;'>" . $error_message . "</span>";
          }
        }
        ?>
      </div>
      <div class="form-group">
        <label for="contrasena">Contraseña:</label>
        <input type="password" placeholder="Ingrese una contraseña segura" class="form-control" id="uspass" name="uspass" required>
      </div>
      <div class="form-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" placeholder="Ingrese su correo electronico" class="form-control" id="usmail" name="usmail" required>
        <?php
        if ($_GET) {
          if (strpos($_GET["error"], "3") !== false) {
            $error_message = "El correo electrónico ingresado ya está registrado.";
            echo "<span class='text-danger' style='font-size:14px;'>" . $error_message . "</span>";
          }
        }
        ?>
      </div>
      <input type="text" hidden id="accion" name="accion" value="nuevo">
      <button type="submit" class="btn btn-primary btn-block mt-3">Enviar</button>
      <a href="indexLogin.php" class="btn btn-secondary mt-3">Átras</a>
    </form>
    <?php
    if ($_GET) {
      if (strpos($_GET["error"], "1") !== false) {
        $error_message = "Por favor, revise los campos del formulario.<br>";
        echo "<span class='text-danger' style='font-size:14px;'>" . $error_message . "</span>";
      }
    }
    ?>
  </div>
</div>


<!-- Agrega el script de validación con Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validate/5.3.0/bootstrap-validate.min.js"></script>
<script src="../Js/login.js"></script>
<?php
include_once '../estructura/footer.php';
?>