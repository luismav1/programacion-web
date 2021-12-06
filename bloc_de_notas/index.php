<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-dark">
<?php if ($_SESSION['mensaje']) echo "ERROR: {$_SESSION['mensaje']}"; ?>
<h3 class="text-white">BLOC DE NOTAS</h3>
<p>
    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseArchivo" role="button" aria-expanded="true"
       aria-controls="collapseArchivo">
        Archivo
    </a>
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCarpeta"
            aria-expanded="false" aria-controls="collapseCarpeta">
        Carpeta
    </button>
</p>
<div class="collapse show" id="collapseArchivo">
    <div class="card card-body bg-light">
        <?php
        $contenido = null;
        $archivo_nombre = null;
        if (($archivo_nombre = urldecode($_GET['archivo']))) {
            $contenido = file_get_contents("archivos/$archivo_nombre");
        }
        ?>
        <form action="guardar-archivo.php" method="post">
            <label class="form-label">Nombre de archivo</label>
            <input name="archivo-nombre" class="form-control" value="<?php echo $archivo_nombre; ?>"><br>
            <textarea name="contenidos" rows="10"
                      cols="30" class="form-control"><?php echo $contenido; ?></textarea>
            <input type="submit" name="guardar-archivo"
                   value="Save" class="btn btn-danger">
            <input type="reset" value="Reestablecer">
        </form>
    </div>
</div>
<div class="collapse" id="collapseCarpeta">
    <div class="card card-body bg-light">

        <form action="guardar-carpeta.php" method="post">
            <label class="form-label">Nombre de directorio</label>
            <input name="nombre-directorio" class="form-control"><br>
            <input type="submit" name="guardar-directorio"
                   value="Save" class="btn btn-danger">
        </form>
    </div>
</div>
<div>
    <?php require 'listar-archivos.php'; ?>
</div>
<?php session_destroy(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>
</html>