<?php
if (isset($_SESSION['mensaje'])) {
    $clase_mensaje =  null;
    if (isset($_SESSION['clase_mensaje'])) {
        $clase_mensaje = $_SESSION['clase_mensaje'];
        unset($_SESSION['clase_mensaje']);
    } else {
        $clase_mensaje = 'danger';
    }
    echo '<h4 class="'.$clase_mensaje.'">'.$_SESSION['mensaje'].'</h4>';
    unset($_SESSION['mensaje']);
}
?>
