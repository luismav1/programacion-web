<?php
require_once 'config/bd.php';

if (isset($_POST['crear_pozo'])) {
    $ubicacion = mysqli_real_escape_string($_POST['ubicacion']);

    $resultado = mysqli_query(
        $conexion,
        "INSERT INTO pozos (ubicacion) VALUES ('{$ubicacion}')"
    );

    if (!$resultado) {
        $_SESSION['mensaje'] = 'Información de pozo inválida';
        header('Location: crear_pozo.php');
    }

    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear pozo</title>
</head>
<body>
<h3>Crear pozo</h3>
<?php
if ($_SESSION['mensaje']) {
    echo '<h2>'.$_SESSION['mensaje'].'</h2>';
    unset($_SESSION['mensaje']);
}
?>
<form action="crear_pozo.php" method="post">
    <input type="text" name="ubicacion" />
    <input type="submit" value="Crear" />
</form>
</body>
</html>