<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
function pagina_actual($path) : bool {
    // Obteniendo la URI actual
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // Comparando exactamente la ruta actual con la esperada
    return $currentPath === $path;
}

