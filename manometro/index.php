<?php
session_start();
require_once 'config/bd.php';
require_once 'autorizacion.php';

require 'head.php';
?>
<body>
<?php require 'nav.php'; ?>
<h3>Pozos </h3>
<a class="btn waves-effect waves-light" href="crear_pozo.php">Crear pozo</a>
<div class="container">
    <?php require 'mensaje.php'; ?>
    <ul class="collection">
        <?php
        $resultado = mysqli_query($conexion, 'SELECT * FROM pozos');

        if ($resultado) {
            while ($pozo = mysqli_fetch_assoc($resultado)) {
                ?>
                <li class="collection-item">
                    <?php echo 'Pozo #' . $pozo['id']; ?> (<?php echo $pozo['ubicacion'] ?>)
                    <a class="btn waves-effect waves-light red" href="eliminar_pozo.php?id=<?php echo $pozo['id']; ?>">
                               <span class="material-icons">
                                   delete
                               </span>
                    </a>
                    <a class="btn waves-effect waves-light" href="editar_pozo.php?id=<?php echo $pozo['id']; ?>">
                               <span class="material-icons">
                                   edit
                               </span>
                    </a>
                    <a class="btn waves-effect waves-light" href="manometro.php?pozo_id=<?php echo $pozo['id']; ?>">
                               <span class="material-icons">
                                   analytics
                               </span>
                    </a>
                </li>
            <?php }
        } else {
            $mensaje = mysqli_error($conexion);
            echo "<h3>$mensaje</h3>";
        }

        ?>
    </ul>
</div>

<?php require 'js.php'; ?>
</body>
</html>