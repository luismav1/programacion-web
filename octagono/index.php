<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Octágono</title>
</head>
<body>
    <?php if (isset($_POST['calcular'])) :
    $lados = $_POST['lados'];
    $mensaje = null;
    $area = null;

    if (!isset($lados) || !is_numeric($lados) || $lados < 0)  {
        $mensaje = '<h1>Número de lados inválido. Intente de nuevo</h1><br><a href="">Volver</a>';
    } else {
        $apotema = $lados / (2*tan(M_PI/4/2));
        $area = 4*$apotema*$lados;

        $mensaje = "<h1>Un octágono regular con lados de $lados, tiene un área de $area</h1>";
    }
    ?>
    <h1><?php echo $mensaje;?></h1>
    <a href="">Volver</a>
    <?php else : ?>
        <form method="post">
            <h3>Calcular el área de un octágono regular</h3>
            <label for="lados">Lados:</label>
            <input name="lados" id="lados" type="number" step="0.001"><br>
            <input type="submit" name="calcular" value="¿Cuánto es?" />
        </form>
    <?php endif; ?>
</body>
</html>