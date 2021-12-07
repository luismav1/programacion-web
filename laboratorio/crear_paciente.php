<?php
require_once 'autorizacion_secretaria.php';

if ($_POST['registrar']) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $cedula = mysqli_real_escape_string($conexion, $_POST['cedula']);

    if (!$nombre || !$apellido || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || !is_numeric($cedula)) {
        $_SESSION['mensaje'] = 'Datos inválidos';
        header('Location: crear_paciente.php');
        die;
    }

    $resultado = mysqli_query($conexion,
        "INSERT INTO pacientes (nombre, apellido, email, cedula) VALUES ('$nombre', '$apellido', '$email', '$cedula')");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: crear_paciente.php');
        die;
    }

    header('Location: index.php');
    die;
}
?>

<?php include 'head.php'; ?>

<div class="container">
    <?php include 'mensaje.php'; ?>
    <form method="post" action="crear_paciente.php">
        <label class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" />
        <label class="form-label">Apellido</label>
        <input type="text" class="form-control" name="apellido" />
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" />
        <label class="form-label">Cédula</label>
        <input type="number" class="form-control" name="cedula" />
        <input type="submit" class="btn btn-danger" name="registrar" value="Registrar paciente">
    </form>
</div>

<?php include 'foot.php'; ?>

