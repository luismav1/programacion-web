<nav>
    <div class="nav-wrapper">
        <a href="index.php" class="brand-logo center">
            <span class="material-icons">
                local_gas_station
            </span>
            Pozos petroleros
        </a>
        <?php if ($_SESSION['usuario']) {?>
            <a href="salir.php" class="btn red">SALIR</a>
        <?php } ?>
    </div>
</nav>
