<?php
require_once 'conexion.php';
require_once 'autorizacion.php';
?>

<?php include 'head.php'; ?>

<div class="container table-responsive">
    <?php include 'mensaje.php'; ?>

    <table class="table">
        <tr>
            <td>ID</td>
            <td>Tipo</td>
            <td>Paciente</td>
            <td>Fecha</td>
        </tr>
        <?php
        $resultado = mysqli_query($conexion, 'SELECT e.*, p.nombre, p.apellido, p.cedula FROM examenes e JOIN pacientes p ON e.paciente_id = p.id');

        $examenes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        foreach ($examenes as $examen) {
            echo "<tr><td>{$examen['id']}</td><td>{$examen['tipo']}</td><td>{$examen['nombre']} {$examen['apellido']}".
            "({$examen['cedula']})</td></tr>";
        }?>
    </table>
</div>

<?php include 'foot.php'; ?>
