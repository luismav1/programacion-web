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
        $mensaje = null;
        $empleado = null;

        for ($i = 0; $i < 3; $i++) {
            $num_empleado = $i + 1;

            $mensaje .="<h3>EMPLEADO #$num_empleado</h3>";

            if (!isset($_POST['nombre'.$i]) || empty($_POST['nombre'.$i])) {
                $mensaje = "<p style='color: red;'>Se requiere el nombre del empleado #$num_empleado</p>";
            } else if (!isset($_POST['apellido'.$i]) || empty($_POST['apellido'.$i])) {
                $mensaje = "<p style='color: red;'>Se requiere el apellido del empleado #$num_empleado</p>";
            } else if (!isset($_POST['cedula'.$i]) || empty($_POST['cedula'.$i]) || !is_numeric($_POST['cedula'.$i]) || strlen($_POST['cedula'.$i]) < 5) {
                $mensaje = "<p style='color: red;'>Empleado #$num_empleado tiene una cedula invalida</p>";
            } else if (!isset($_POST['salario'.$i]) || empty($_POST['salario'.$i]) || !is_numeric($_POST['salario'.$i]) || $_POST['salario'.$i] <= 0) {
                $mensaje = "<p style='color: red;'>Empleado #$num_empleado tiene un salario invalido</p>";
            } else if (!isset($_POST['departamento'.$i]) || empty($_POST['departamento'.$i])) {
                $mensaje = "<p style='color: red;'>Se requiere el departamento del empleado #$num_empleado</p>";
            } else if (!isset($_POST['lugar-trabajo'.$i]) || empty($_POST['lugar-trabajo'.$i])) {
                $mensaje = "<p style='color: red;'>Se requiere el lugar de trabajo del empleado #$num_empleado</p>";
            } else {
                $empleado = array(
                    'nombre' => $_POST['nombre'.$i],
                    'apellido' => $_POST['apellido'.$i],
                    'cedula' => $_POST['cedula'.$i],
                    'salario' => $_POST['salario'.$i],
                    'departamento' => $_POST['departamento'.$i],
                    'lugar-trabajo' => $_POST['lugar-trabajo'.$i],
                );

                $mensaje .= '<div>';
                $mensaje .= '<p><b>Nombre completo: </b> '.$empleado['nombre'].' '.$empleado['apellido'].'</p>';
                $mensaje .= '<p><b>C.I.:</b> '.$empleado['cedula'].'</p>';
                $mensaje .= '<p><b>Sueldo:</b> $ '.$empleado['salario'].'</p>';
                $mensaje .= '<p><b>Departamento: </b> '.$empleado['departamento'].'</p>';
                $mensaje .= '<p><b>Lugar de trabajo: </b> '.$empleado['lugar-trabajo'].'</p>';
                $mensaje .= '</div>';
            }

            if (is_null($empleado)) {
                break;
            }
        }

        echo $mensaje;
        ?>
        <a href="">Volver</a>
    <?php else : ?>
        <form method="post">
            <?php for ($i = 0; $i < 3; $i++) { ?>
                <div>
                    <h4>Empleado <?php echo $i + 1; ?></h4>
                    <label for="nombre<?php echo $i; ?>">Nombre:</label><br>
                    <input name="nombre<?php echo $i; ?>" id="nombre<?php echo $i; ?>" /><br>
                    <label for="apellido<?php echo $i; ?>">Apellido:</label><br>
                    <input name="apellido<?php echo $i; ?>" id="apellido<?php echo $i; ?>"  /><br>
                    <label for="cedula<?php echo $i; ?>">Cédula:</label><br>
                    <input name="cedula<?php echo $i; ?>" id="cedula<?php echo $i; ?>"/><br>
                    <label for="salario<?php echo $i; ?>">Salario:</label><br>
                    <input type="number" step=".01" name="salario<?php echo $i; ?>"  id="salario<?php echo $i; ?>"  /><br>
                    <label for="departamento<?php echo $i; ?>">Departamento:</label><br>
                    <input name="departamento<?php echo $i; ?>" id="departamento<?php echo $i; ?>"<?php echo $i; ?>"  /><br>
                    <label for="lugar-trabajo<?php echo $i; ?>">Lugar de trabajo:</label><br>
                    <input name="lugar-trabajo<?php echo $i; ?>" id="lugar-trabajo<?php echo $i; ?>"  /><br>
                </div>
            <?php } ?>
            <input type="submit" name="registrar" id="registrar" value="Registrar" />
            <input type="reset" name="limpiar" id="limpiar" value="Limpiar" />
        </form>
    <?php endif; ?>
</body>
</html>