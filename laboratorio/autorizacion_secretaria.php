<?php
require_once 'conexion.php';
require_once 'autorizacion.php';

$resultado = mysqli_query(
    'SELECT * FROM usuarios WHERE id =' .mysqli_real_escape_string($conexion, $usuario_id));

if (!$resultado) {
    exit(mysqli_error($conexion));
}

$secretaria = mysqli_fetch_assoc($conexion);

if (!$secretaria) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($secretaria['tipo'] !== 'secretaria') {
    header('Location: index.php');
    exit;
}

