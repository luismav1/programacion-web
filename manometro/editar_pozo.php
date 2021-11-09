<?php
session_start();

require_once 'config/bd.php';
require_once 'autorizacion.php';

if (isset($_POST['editar_pozo']) && isset($_POST['id'])) {
    $ubicacion = $_POST['ubicacion'];
    $id = mysqli_real_escape_string($conexion, $_POST['id']);

    $resultado = mysqli_query($conexion, "SELECT * FROM pozos WHERE id = '$id'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: editar_pozo.php');
        die;
    }

    $pozo = mysqli_fetch_assoc($resultado);

    if (!$pozo) {
        $_SESSION['mensaje'] = 'Pozo inválido';
        header('Location: index.php');
        die;
    }

    if (strlen($ubicacion) > 120 || strlen($ubicacion) < 10) {
        $_SESSION['mensaje'] = 'La ubicación del pozo debe tener un máximo de 120 caracteres, mínimo 10.';
        header('Location: editar_pozo.php');
        die;
    }

    $ubicacion_segura = mysqli_real_escape_string($conexion, $ubicacion);

    $resultado = mysqli_query($conexion, "UPDATE pozos SET ubicacion = '$ubicacion_segura' WHERE id = '$id'");

    if (!$resultado) {
        $_SESSION['mensaje'] = 'Error en consulta';
        header('Location: editar_pozo.php');
        die;
    }

    $_SESSION['mensaje'] = 'Pozo';
    header('Location: index.php');
    die;
} else {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $resultado = mysqli_query($conexion, "SELECT * FROM pozos WHERE id = '$id'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: editar_pozo.php');
        die;
    }

    $pozo = mysqli_fetch_assoc($resultado);

    if (!$pozo) {
        $_SESSION['mensaje'] = 'Pozo inválido';
        header('Location: index.php');
        die;
    }
}
?>
<?php require 'head.php'; ?>
<body>
    <?php require 'nav.php'; ?>
    <h3>Editar pozo</h3>
    <div class="container">
        <?php require 'mensaje.php'; ?>
        <form action="editar_pozo.php" method="post">
            <input type="hidden" name="id" value="<?php echo $pozo['id'];?>" >
            <div class="input-field">
                <label for="ubicacion">Ubicación</label>
                <input type="text" name="ubicacion"
                       maxlength="120"
                       class="validate"
                        id="ubicacion"
                       value="<?php echo $pozo['ubicacion']; ?>"
                        />
                <span class="helper-text"
                      data-error="wrong"
                      data-success="right">
                    Ubicación del pozo debe tener un máximo de
                    120 caracteres, mínimo 10.
                </span>
            </div>
            <input type="submit" value="Editar" name="editar_pozo" />
        </form>
    </div>
    <?php require 'js.php'; ?>
</body>
</html>