<?php
// Controlador Frontal (Front Controller)

// Obtener la ruta base dinámica (por si se ejecuta en una subcarpeta como localhost/sistema completo para restaurante/)
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Eliminar el base_path de la URI para tener una ruta limpia
if (strpos($request_uri, $base_path) === 0) {
    $path = substr($request_uri, strlen($base_path));
} else {
    $path = $request_uri;
}

// Si la ruta está vacía, estamos en la raíz
if (empty($path)) {
    $path = '/';
}

// Enrutador
switch ($path) {
    case '/':
    case '/index.php':
        require __DIR__ . '/views/home.php';
        break;
    case '/admin':
    case '/admin/':
        require __DIR__ . '/views/admin/login.php';
        break;
    default:
        http_response_code(404);
        echo "404 - Página no encontrada";
        break;
}
