<?php
require_once 'autorizacion_bioanalista.php';

$examen = null;

if ($_POST['resultados']) {
    $resultado = mysqli_real_escape_string($conexion, $_POST['resultado']);
    $examen_id = mysqli_real_escape_string($conexion, $_POST['examen_id']);

    $resultado_2 = mysqli_query($conexion, "UPDATE examenes SET resultados = '$resultado', estado = 'completado' WHERE id = '$examen_id'");

    if (!$resultado_2) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: resultados_examen.php');
        exit;
    }

    header('Location: enviar_examen.php?id='.$examen_id);
    exit;
} else {
    $examen_id = $_GET['id'];

    if (!$examen_id) {
        header('Location: index.php');
        exit;
    }

    $resultado_2 = mysqli_query($conexion,
        "SELECT * FROM examenes WHERE id = '$examen_id'");

    if (!$resultado_2) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
        header('Location: resultados_examen.php');
        exit;
    }

    $examen = mysqli_fetch_assoc($resultado_2);
}
?>
<?php require 'head.php'; ?>

<form method="post" action="resultados_examen.php">
    <input type="hidden" name="examen_id" value="<?php echo $examen['id']?>">
    <textarea name="resultado" class="form-control"></textarea>
    <input type="submit" name="resultados" class="btn btn-danger" value="ENVIAR" >
</form>

<?php require 'foot.php'; ?>