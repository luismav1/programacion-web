<?php
session_start();

require_once 'config/bd.php';
require_once 'autorizacion.php';

$medida = null;

if (isset($_POST['editar_medida']) && isset($_POST['id']) && isset($_POST['pozo_id'])) {
    $medida = $_POST['medida'];
    $tiempo = $_POST['fecha'] . ' ' .$_POST['hora'];
    $pozo_id = $_POST['pozo_id'];
    $id = $_POST['id'];

    if (floatval($medida) <= 0) {
        $_SESSION['mensaje'] = 'Medida inválida';
        header('Location: editar_medida.php?id='.$id);
        exit;
    }

    if (!DateTime::createFromFormat('Y-m-d H:i:s', $tiempo)) {
        $_SESSION['mensaje'] = 'Fecha inválida';
        header('Location: editar_medida.php?pozo_id='.$pozo_id);
        exit;
    }

    $fecha_segura = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora_segura = mysqli_real_escape_string($conexion, $_POST['hora']);
    $id_seguro = mysqli_real_escape_string($conexion, $id);
    $ubicacion_segura = mysqli_real_escape_string($conexion, $pozo_id);

    $resultado = mysqli_query($conexion, "UPDATE manometro SET valor = '$medida', fecha = '$fecha_segura', hora = '$hora_segura', ubicacion = '$ubicacion_segura' WHERE id = '$id_seguro'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: manometro.php?pozo_id='.$pozo_id);
        exit;
    }

    $_SESSION['mensaje'] = 'Medida editada exitosamente';
    $_SESSION['clase_mensaje'] = 'success';

    header('Location: manometro.php?pozo_id='.$pozo_id);
    exit;
} else {
    $medida_id = mysqli_escape_string($conexion, $_GET['id']);

    if (!$medida_id) {
        header('Location: index.php');
        exit;
    }

    $resultado = mysqli_query($conexion, "SELECT * FROM manometro WHERE id = '$medida_id'");
    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        $_SESSION['clase_mensaje'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $medida = mysqli_fetch_assoc($resultado);

    if (!$medida) {
        $_SESSION['mensaje'] = 'Medida inexistente';
        $_SESSION['clase_mensaje'] = 'danger';
        header('Location: index.php');
        exit;
    }

}?>
<?php require 'head.php'; ?>
<body>
<?php require 'nav.php'; ?>
<h3>Editar medición</h3>
<div class="container">
    <form action="editar_medida.php" method="post">
        <?php require 'mensaje.php'; ?>
        <input type="hidden" name="id" value="<?php echo $medida['id']; ?>">
        <input type="hidden" name="pozo_id" value="<?php echo $medida['ubicacion']; ?>">
        <div class="input-field">
            <label for="medida">Medida del manómetro</label>
            <input type="number" name="medida"
                   min="0"
                   step=".01"
                   class="validate"
                   id="medida"
                   value="<?php echo $medida['valor']; ?>"
            />
            <span class="helper-text"
                  data-error="wrong"
                  data-success="right">
                    Medida en bar
                </span>
        </div>
        <div class="input-field">
            <input type="date" name="fecha"
                   id="fecha"
                value="<?php echo $medida['fecha']; ?>"
            >

            <span class="helper-text"
                  data-error="wrong"
                  data-success="right">
                    Tiempo de lectura
                </span>
        </div>
        <div class="input-field">
            <input type="time" name="hora"
                   class="validate"
                   value="<?php echo $medida['hora']; ?>"
                   id="hora">
        </div>
        <input type="submit" value="Editar" class="btn waves-effect waves-light" name="editar_medida" />
    </form>
    <a href="manometro.php?pozo_id=<?php echo $medida['id']; ?>">Atrás</a>

</div>
<?php require 'js.php'; ?>
</body>
</html>
