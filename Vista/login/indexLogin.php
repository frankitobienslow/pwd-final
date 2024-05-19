<?php
include_once '../Estructura/headLibre.php';
?>
<title>Iniciar sesión | wesh wesh</title>
<div class="container d-flex justify-content-center p-5">
    <form action="accionLogin.php" method="POST" id="loginForm" class="row g-3 needs-validation">
        <input type="hidden" name="accion" value="login">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title fw-bold text-center">Iniciar sesión</h5>
                <div class="col-md">

                    <label for="validationCustom01" class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="usnombre" id="nombre" placeholder="Ingrese su usuario" required>

                </div>
                <div class="col-md">
                    <label for="validationCustom02" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="uspass" id="password" placeholder="Ingrese su contraseña" required>

                </div>

                <div class="col-12 mt-3">
                    <button class="btn btn-primary" id="enviar" type="submit">Ingresar</button>
                    <a href="register.php" class="btn btn-secondary" id="enviar">Registrarse</a>
                </div>

            </div>
            <?php if ($_GET) {
        if (strpos($_GET["error"], "1") !== false) {
            $error_message = "Credenciales incorrectas.";
        }
        if (strpos($_GET["error"], "2") !== false) {
            $error_message = "Por favor, revise los campos del formulario.<br>";
        }
        echo '<div class="alert alert-danger text-center" style="font-size:14px;"role="alert">' . $error_message . '</div>';
    } ?>
        </div>

    </form>
   
</div>


<!--LINK JS-->
<script src="../Js/forms.js"></script>


<?php
include_once '../estructura/footer.php';
?>