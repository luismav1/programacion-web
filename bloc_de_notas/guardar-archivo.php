<?php
session_start();

if (!$_POST['archivo-nombre']) {
  $_SESSION['mensaje'] = 'Petición inválida';
  header('Location: index.php');
  die;
}

$nombre = str_replace('.txt', '', $_POST['archivo-nombre']);

if (empty($nombre)) {
  $_SESSION['mensaje'] = 'Nombre de archivo vacío';
  header('Location: index.php');
  die;
}

if ($archivo = fopen("archivos/$nombre.txt", "w")) {
    fwrite($archivo, $_POST['contenidos']);
    fclose($archivo);
} else {
    $_SESSION['mensaje'] = 'No se pudo guardar archivo';
}

header('Location: index.php?archivo='.urlencode("$nombre.txt"));
die;