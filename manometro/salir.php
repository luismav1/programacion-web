<?php

session_start();

require_once 'autorizacion.php';

session_destroy();

header('Location: acceder.php');
die;