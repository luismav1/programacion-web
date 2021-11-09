<?php
session_start();
require_once 'config/bd.php';
require_once 'no_autorizacion.php';

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];


    if (!$usuario || !$contrasenia) {
        $_SESSION['mensaje'] = 'Información incompleta';
        header('Location: registro_usuario.php');
        die;
    };

    $usuario_seguro = mysqli_real_escape_string($conexion, $usuario);
    $resultado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre = '$usuario_seguro'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: registro_usuario.php');
        die;
    }

    if (!($registro_usuario = mysqli_fetch_assoc($resultado))) {

        $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT);
        $resultado = mysqli_query($conexion,
            "INSERT INTO usuarios (nombre, contrasenia) VALUES ('$usuario_seguro', '$contrasenia')");

        if (!$resultado) {
            $_SESSION['mensaje'] = mysqli_error($conexion);
            header('Location: registro_usuario.php');
            die;
        }

        header('Location: acceder.php');
        die;
    } else {
        $_SESSION['mensaje'] = 'Usuario o contraseña inválida';
        header('Location: registro_usuario.php');
        die;
    }
}

require 'head.php'; ?>
<body>
<?php require 'nav.php'; ?>

<div class="container">
    <div class="container text-center">
        <h3>¡Regístrese!</h3>
    </div>
    <form action="registro_usuario.php" method="post">
        <?php require 'mensaje.php'; ?>
        <div class="text-input">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario"/>
        </div>
        <div class="text-input">
            <label for="contrasenia">Contraseña</label>
            <input type="password" name="contrasenia" id="contrasenia"/>
        </div>
        <a href="acceder.php" >¿Ya tiene una cuenta? Ingrese</a><br><br>
        <button class="btn waves-effect waves-light" type="submit" name="registrar">
            Registrar
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>

<?php require 'js.php'; ?>
</body>
</html>

