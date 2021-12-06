<?php
// Does not support flag GLOB_BRACE
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir . '/' . basename($pattern), $flags));
    }
    return $files;
}

$archivos = rglob(__DIR__ . "/archivos/*");
echo "<ul class='list-group'>";

foreach ($archivos as $archivo) {
    $archivo_url = urlencode(str_replace(__DIR__.'/archivos/', '', $archivo));
    $archivo_filtro = str_replace(__DIR__.'/archivos/', '', $archivo);
    if (strpos($archivo,'.txt') !== false) {
        echo "<li class='list-group-item bg-light'><a href='index.php?archivo=$archivo_url'>$archivo_filtro</a> (<a href='eliminar-archivo.php?archivo=$archivo_url'>Eliminar</a>)</li>";
    } else {
        echo "<li class='list-group-item bg-light'>$archivo_filtro (<a href='eliminar-directorio.php?archivo=$archivo_url'>Eliminar</a>)</li>";
    }
}
echo "</ul>";
