<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    die;
}

$usuario_id = $_SESSION['usuario'];

