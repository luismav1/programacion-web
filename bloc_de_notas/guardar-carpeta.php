<?php
session_start();

if (!$_POST['guardar-directorio']) {
  $_SESSION['mensaje'] = 'Petición inválida';
  header('Location: index.php');
  die;
}

$nombre = str_replace('.txt', '', $_POST['nombre-directorio']);

if (empty($nombre)) {
  $_SESSION['mensaje'] = 'Nombre de directorio está vacío';
  header('Location: index.php');
  die;
}

if (!mkdir("archivos/$nombre")) {
  $_SESSION['mensaje'] = 'Directorio no se pudo guardar';
}

header('Location: index.php');
  die;