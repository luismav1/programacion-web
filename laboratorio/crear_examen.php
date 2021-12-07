<?php
require_once 'autorizacion_secretaria.php';

if ($_POST['registrar']) {
    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
    $paciente = mysqli_real_escape_string($conexion, $_POST['paciente_id']);
    $procedimiento = mysqli_real_escape_string($conexion, $_POST['procedimiento']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);

    if (!$tipo || !$paciente || !$procedimiento || !$fecha) {
        $_SESSION['mensaje'] = 'No se aceptan datos vacíos';
        header('Location: crear_examen.php');
        exit;
    }

    $resultado = mysqli_query($conexion,
        "INSERT INTO examenes (tipo_examen, paciente_id, procedimiento, fecha) VALUES ('$tipo', '$paciente', '$procedimiento', '$fecha')");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: crear_examen.php');
        exit;
    }

    $_SESSION['mensaje'] = 'Examen agregado exitosamente';
    $_SESSION['clase_mensaje'] = 'success';
    header('Location: index.php');
    exit;
}
?>
<?php include 'head.php'; ?>

<div class="container">
    <?php include 'mensaje.php'; ?>
    <form method="post" action="crear_examen.php">
        <label class="form-label">Tipo</label>
        <input type="text" class="form-control" name="tipo" />
        <label class="form-label">Paciente</label>
        <select name="paciente_id" class="form-select">
            <?php
            $resultado = mysqli_query($conexion, "SELECT * FROM pacientes");

            if (!$resultado) {
                echo mysqli_error($conexion);
            } else {
            $pacientes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

            foreach ($pacientes as $paciente) {?>
                <option value="<?php echo $paciente['id'];?>">
                    <?php echo "{$paciente['cedula']} .- {$paciente['nombre']} {$paciente['apellido']}"; ?>
                </option>
            <?php } ?>
         <?php   } ?>
        </select>
        <label>Fecha</label>
        <input name="fecha" type="datetime-local" class="form-control">
        <label>Procedimiento</label>
        <textarea name="procedimiento" cols="30" rows="10" class="form-control"></textarea>
        <input type="submit" class="btn btn-danger" name="registrar" value="Registrar examen">
    </form>
</div>

<?php include 'foot.php'; ?>
