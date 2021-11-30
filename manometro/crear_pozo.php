<?php
session_start();

require_once 'config/bd.php';
require_once 'autorizacion.php';

if (isset($_POST['crear_pozo'])) {
    $ubicacion = $_POST['ubicacion'];

    if (strlen($ubicacion) > 120 || strlen($ubicacion) < 10) {
        $_SESSION['mensaje'] = 'La ubicación del pozo debe tener un máximo de 120 caracteres, mínimo 10.';
        header('Location: crear_pozo.php');
        exit;
    }

    $ubicacion_segura = mysqli_real_escape_string($conexion, $ubicacion);

    $resultado = mysqli_query($conexion, "INSERT INTO pozos (ubicacion) VALUES ('$ubicacion_segura')");

    if (!$resultado) {
        $_SESSION['mensaje'] = 'Error en consulta';
        header('Location: crear_pozo.php');
        exit;
    }

    $_SESSION['mensaje'] = 'Pozo';
    header('Location: index.php');
    exit;
}
?>
<?php require 'head.php'; ?>
<body>
    <?php require 'nav.php'; ?>
    <h3>Crear pozo</h3>
    <div class="container">
        <?php require 'mensaje.php'; ?>
        <form action="crear_pozo.php" method="post">
            <div class="input-field">
                <label for="ubicacion">Ubicación</label>
                <input type="text" name="ubicacion"
                       minlength="10"
                       maxlength="120"
                       class="validate"
                        id="ubicacion"
                        />
                <span class="helper-text"
                      data-error="wrong"
                      data-success="right">
                    Ubicación del pozo debe tener un máximo de
                    120 caracteres, mínimo 10.
                </span>
            </div>
            <input type="submit" value="Crear" class="btn waves-effect waves-light" name="crear_pozo" />
        </form>
        <a href="index.php">Atrás</a>
    </div>
    <?php require 'js.php'; ?>
</body>
</html>