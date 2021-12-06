<?php

$archivo = urldecode($_GET['archivo']);

if (!unlink("archivos/".$archivo)) {
    $_SESSION['mensaje'] = 'No se pudo borrar el archivo';
    header('Location: index.php');
}

header("Location: index.php");
exit;