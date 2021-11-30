<?php
session_start();

require_once 'config/bd.php';
require_once 'autorizacion.php';

if (isset($_POST['crear_medida']) && isset($_POST['pozo_id'])) {
    $medida = $_POST['medida'];
    $tiempo = $_POST['fecha'] . ' ' .$_POST['hora'] . ':00';
    $pozo_id = $_POST['pozo_id'];

    if (floatval($medida) <= 0) {
        $_SESSION['mensaje'] = 'Medida inválida';
        header('Location: crear_medida.php?pozo_id='.$pozo_id);
        exit;
    }

    if (!DateTime::createFromFormat('Y-m-d H:i:s', $tiempo)) {
        $_SESSION['mensaje'] = 'Fecha inválida';
        header('Location: crear_medida.php?pozo_id='.$pozo_id);
        exit;
    }

    $fecha_segura = mysqli_escape_string($conexion, $_POST['fecha']);
    $hora_segura = mysqli_escape_string($conexion, $_POST['hora'] .':00');
    $id_seguro = mysqli_real_escape_string($conexion, $pozo_id);

    $resultado = mysqli_query($conexion, "INSERT INTO manometro (valor, fecha, hora, ubicacion) VALUES ('$medida', '$fecha_segura', '$hora_segura', '$id_seguro')");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: manometro.php?pozo_id='.$pozo_id);
        exit;
    }

    $_SESSION['mensaje'] = 'Medida agregada exitosamente';
    $_SESSION['clase_mensaje'] = 'success';

    header('Location: manometro.php?pozo_id='.$pozo_id);
    exit;
} else {
    $pozo_id = $_GET['pozo_id'];

    if (!$pozo_id) {
        header('Location: index.php');
        exit;
    }
}?>
<?php require 'head.php'; ?>
<body>
<?php require 'nav.php'; ?>
<h3>Registrar medición</h3>
<div class="container">
    <form action="crear_medida.php" method="post">
        <?php require 'mensaje.php'; ?>

        <input type="hidden" name="pozo_id" value="<?php echo $pozo_id; ?>">
        <div class="input-field">
            <label for="medida">Medida del manómetro</label>
            <input type="number" name="medida"
                   min="0"
                   step=".01"
                   class="validate"
                   id="medida"
            />
            <span class="helper-text"
                  data-error="wrong"
                  data-success="right">
                    Medida en bar
                </span>
        </div>
        <div class="input-field">
            <input type="date" name="fecha"
                   id="fecha" >

            <span class="helper-text"
                  data-error="wrong"
                  data-success="right">
                    Tiempo de lectura
                </span>
        </div>
        <div class="input-field">
            <input type="time" name="hora"
                   class="validate"
                   id="hora">
        </div>
        <input type="submit" value="Crear" class="btn waves-effect waves-light" name="crear_medida" />
    </form>
    <a href="manometro.php?pozo_id=<?php echo $pozo_id; ?>">Atrás</a>
</div>
<?php require 'js.php'; ?>
</body>
</html>
