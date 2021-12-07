<?php
require_once 'conexion.php';
require_once 'no_autorizacion.php';

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];
    $tipo = $_POST['tipo_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];


    if (!$usuario || !$contrasenia) {
        $_SESSION['mensaje'] = 'Información incompleta';
        header('Location: signup.php');
        die;
    };

    $usuario_seguro = mysqli_real_escape_string($conexion, $usuario);
    $tipo = mysqli_real_escape_string($conexion, $tipo);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellido = mysqli_real_escape_string($conexion, $apellido);

    $resultado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre = '$usuario_seguro'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: signup.php');
        die;
    }

    if (!($registro_usuario = mysqli_fetch_assoc($resultado))) {

        $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT);
        $resultado = mysqli_query($conexion,
            "INSERT INTO usuarios (usuario, password, nombre, apellido, tipo) VALUES ('$usuario_seguro', '$contrasenia', '$nombre', '$apellido', '$tipo')");

        if (!$resultado) {
            $_SESSION['mensaje'] = mysqli_error($conexion);
            header('Location: signup.php');
            die;
        }

        header('Location: login.php');
        die;
    } else {
        $_SESSION['mensaje'] = 'Usuario o contraseña inválida';
        header('Location: signup.php');
        die;
    }
}

?>
<?php include 'head.php'; ?>

<div class="container">
    <div class="card bg-info">
        <div class="card-body">
            <?php include 'mensaje.php'; ?>
            <form method="post" action="signup.php">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" />
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" />
                <label class="form-label">Apellido</label>
                <input type="text" class="form-control" name="apellido" />
                <label class="form-label">Tipo de usuario</label>
                <select name="tipo_usuario" class="form-select">
                    <option value="secretaria">Secretaria</option>
                    <option value="bioanalista">Bioanalista</option>
                </select>
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasenia" />
                <input type="submit" class="btn btn-danger" name="registrar" value="REGISTRAR">
            </form>
            <a href="login.php">Ya tiene una cuenta? ¡Acceda!</a>
        </div>
    </div>

</div>

<?php include 'foot.php'; ?>


