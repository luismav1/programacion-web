<?php
session_start();
require_once 'config/bd.php';
require_once 'autorizacion.php';

if (isset($_GET['id'])) {
    $id_seguro = mysqli_real_escape_string($conexion, $_GET['id']);

    $resultado = mysqli_query($conexion, "DELETE FROM manometro WHERE id = '$id_seguro'");

    if (!$resultado) {
        $_SESSION['mensaje'] = mysqli_error($conexion);
    }
}
header('Location: index.php');
exit;
?>