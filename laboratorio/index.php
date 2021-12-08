<?php
require_once 'conexion.php';
require_once 'autorizacion.php';

$resultado = mysqli_query($conexion,
    "SELECT * FROM usuarios WHERE id =".mysqli_real_escape_string($conexion, $usuario_id));

if (!$resultado) {
    die(mysqli_error($conexion));
}

$usuario_actual = mysqli_fetch_assoc($resultado);

?>


<?php include 'head.php'; ?>

<div class="container table-responsive">

    <div class="card">
        <div class="card-body">
            <?php include 'mensaje.php'; ?>

            <div>
                <?php if ($usuario_actual['tipo'] === 'secretaria') { ?>
                    <a class="btn btn-primary" href="crear_examen.php">CREAR EXAMEN</a>
                    <a class="btn btn-danger" href="crear_paciente.php">CREAR PACIENTE</a>
                <?php } ?>
                <a class="btn btn-danger" href="salir.php">SALIR</a>
            </div>
            <table class="table">
                <tr>
                    <td>ID</td>
                    <td>Tipo</td>
                    <td>Paciente</td>
                    <td>Fecha</td>
                    <td>Acciones</td>
                </tr>
                <?php
                $resultado = mysqli_query($conexion, 'SELECT e.*, p.nombre, p.apellido, p.cedula FROM examenes e JOIN pacientes p ON e.paciente_id = p.id');

                $examenes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

                foreach ($examenes as $examen) {
                    $html = "<tr><td>{$examen['id']}</td><td>{$examen['tipo_examen']}</td><td>{$examen['nombre']} {$examen['apellido']}".
                        "({$examen['cedula']})</td><td>{$examen['fecha']}</td>";


                    if ($examen['estado'] === 'completado') {
                        $html .= "<td><a href='enviar_examen.php?id={$examen['id']}' class='btn btn-primary'>Enviar</a>";
                    } else if ($usuario_actual['tipo'] === 'bioanalista') {
                        $html .= "<td><a href='resultados_examen.php?id={$examen['id']}' class='btn btn-primary'>Agregar resultados</a>";
                    }

                    $html .= '</tr>';
                    echo $html;
                }?>
            </table>
        </div>
    </div>

</div>

<?php include 'foot.php'; ?>
