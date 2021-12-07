<?php
session_start();

if (!$_SESSION['usuario']) {
    header('Location: login.php');
    die;
}

$usuario_id = $_SESSION['usuario'];

