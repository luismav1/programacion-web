<?php
require_once 'config/bd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pozos petroleros</title>
</head>
<body>
    <h3>Pozos </h3>
    <ul>
        <?php
        $resultado = mysqli_query($conexion, 'SELECT * FROM pozos');

        while ($pozo = mysqli_fetch_assoc($resultado)) {
        ?>
            <li><?php echo 'Pozo '.$pozo['id']; ?> (<?php echo $pozo['ubicacion']?>)</li>
        <?php }

        ?>
    </ul>
</body>
</html>