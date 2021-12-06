<?php

$directorio = urldecode($_GET['archivo']);

if (!rmdir("archivos/".$directorio)) {
    $_SESSION['mensaje'] = 'No se pudo borrar la carpeta';
    header('Location: index.php');
}

header("Location: index.php");
exit;