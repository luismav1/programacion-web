<?php
session_start();

require_once 'config/bd.php';
require_once 'autorizacion.php';

$pozo_id = mysqli_real_escape_string($conexion, $_GET['pozo_id']);

$resultado = mysqli_query($conexion, "SELECT * FROM pozos WHERE id = '$pozo_id'");

if (!$resultado) {
    $_SESSION['mensaje'] = mysqli_error($conexion);
    header('Location: index.php');
}

$pozo = mysqli_fetch_assoc($resultado);

if (!$pozo) {
    $_SESSION['mensaje'] = 'Pozo inexistente';
    header('Location: index.php');
}

?>
<?php require 'head.php'; ?>
<body>
<?php require 'nav.php'; ?>
<h3>Manómetro de pozo #<?php echo $pozo['id'];?></h3>
<?php if ($error = mysqli_error($conexion)) {?>
    <h4><?php echo $error; ?></h4>
<?php }?>
<h5><a class="btn waves-effect waves-light" href="crear_medida.php?pozo_id=<?php echo $pozo['id'];?>">Nueva medida</a></h5>
<div class="container">
    <?php require 'mensaje.php'; ?>
    <div class="row">
        <div class="col s12 m3">
            <ul class="collection scroll_50">
                <?php
                $resultado = mysqli_query($conexion, 'SELECT * FROM manometro WHERE ubicacion = '.$pozo_id.' ORDER BY fecha DESC, hora DESC');

                if ($resultado) {

                    $manometros = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
                    foreach ($manometros as $manometro) {
                        ?>
                        <li class="collection-item">
                            <h5><?php echo 'Medida #' . $manometro['id']; ?> (<?php echo $manometro['fecha'] . ' ' . $manometro['hora'] ?>)</h5>
                            <h6><?php echo $manometro['valor']; ?> bar</h6>
                            <a class="btn waves-effect waves-light red" href="eliminar_medida.php?id=<?php echo $manometro['id']; ?>">
                               <span class="material-icons">
                                   delete
                               </span>
                            </a>
                            <a class="btn waves-effect waves-light" href="editar_medida.php?id=<?php echo $manometro['id']; ?>">
                               <span class="material-icons">
                                   edit
                               </span>
                            </a>
                        </li>
                    <?php } ?>

                <?php } ?>
            </ul>
        </div>
        <div class="col s12 m9">
            <canvas id="grafica"></canvas>
        </div>
    </div>
    <a href="index.php">Atrás</a>
</div>
<?php require 'js.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js" integrity="sha256-7lWo7cjrrponRJcS6bc8isfsPDwSKoaYfGIHgSheQkk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>

<script>
    var chart = new Chart(document.getElementById('grafica').getContext('2d'), {
        type: 'line',
        data: {
        datasets: [{
            label: "<?php echo $pozo['name']; ?>",
            data: [
                <?php
                echo implode(', ', array_map(function ($manometro) {
                    return json_encode([
                        'y' => $manometro['valor'],
                        'x' => $manometro['fecha'] . ' ' . $manometro['hora']
                    ]);
                }, $manometros));
                ?>
            ].map(function(value) {
                return {
                    y: value.y,
                    x: Date.parse(value.x)
                }
            }),
            fill: false,
            borderColor: 'rgb(200, 0, 10)',
            backgroundColor: 'red',
            pointBackgroundColor: 'red',
            tension: 0.1
        }]
        },
        options: {
        scales: {
            x: {
                type: 'time',
                    time: {
                    unit: 'day'
                }
            }
        },
        zone: "Venezuela/Caracas"
    }
    })
</script>
</body>
</html>

