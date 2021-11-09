<?php
if (!isset($_SESSION['usuario'])) {
    header('Location: acceder.php');
    die;
}
?>