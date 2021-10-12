<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triángulo rectángulo</title>
</head>
<body>
    <?php if (isset($_POST['calcular'])) :
        $cateto1 = 3;
        $cateto2 = 4;

        $hipotenusa = sqrt(pow($cateto1, 2)+pow($cateto2, 2));
        ?>
        <h1>
            Un triangulo con un cateto de <?php echo $cateto1 ?> cm y otro de <?php echo $cateto2 ?>cm
            tiene una hipotenusa de <?php echo $hipotenusa ?>cm
        </h1>
    <?php else : ?>
    <form method="post">
        <input type="submit" name="calcular" />
    </form>
    <?php endif; ?>
</body>
</html>