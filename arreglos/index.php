<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arreglos</title>
</head>
<body>
    <?php if (isset($_POST['registrar'])) :

    ?>
    <?php else : ?>
    <form method="post">
        <?php for ($i = 0; $i < 3; $i++) { ?>
        <div>
            <label for="nombre<?php echo $i; ?>">Nombre:</label><br>
            <input name="nombre<?php echo $i; ?>" id="nombre<?php echo $i; ?>" /><br>
            <label for="apellido<?php echo $i; ?>">Apellido:</label><br>
            <input name="apellido<?php echo $i; ?>" id="apellido<?php echo $i; ?>" /><br>
            <label for="cedula<?php echo $i; ?>">Cédula:</label><br>
            <input name="apellido<?php echo $i; ?>" id="apellido<?php echo $i; ?>" /><br>
        </div>

        <?php } ?>
    </form>
    <?php endif; ?>
</body>
</html>