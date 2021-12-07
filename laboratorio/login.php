<?php
include_once 'conexion.php';
include_once  'no_autorizacion.php';

if (isset($_POST['acceder'])) {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];


    if (!$usuario || !$contrasenia) {
        $_SESSION['mensaje'] = 'Información incompleta';
        header('Location: acceder.php');
        die;
    }

    $usuario_seguro = mysqli_real_escape_string($conexion, $usuario);
    $resultado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario_seguro'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: acceder.php');
        die;
    }

    if ($registro_usuario = mysqli_fetch_assoc($resultado)) {

        if (password_verify($contrasenia, $registro_usuario['password'])) {
            $_SESSION['usuario'] = $registro_usuario['id'];
            header('Location: index.php');
            die;
        }

        $_SESSION['mensaje'] = 'Usuario o contraseña inválida';
        header('Location: login.php');
        die;
    } else {
        $_SESSION['mensaje'] = 'Usuario o contraseña inválida';
        header('Location: login.php');
        die;
    }
}
?>
<?php include 'head.php'; ?>

<div class="container">
    <div class="card bg-info">
        <div class="card-body">
            <?php include 'mensaje.php'; ?>
            <form method="post" action="login.php">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" />
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasenia" />
                <input type="submit" class="btn btn-danger" name="acceder" value="ACCEDER">
            </form>
            <a href="signup.php">No tiene una cuenta? regístrese!</a>
        </div>
    </div>

</div>

<?php include 'foot.php'; ?>