<?php
header('Content-Type: application/json');

// Requerir la conexión a la base de datos
require_once __DIR__ . '/config/database.php';

$database = new Database();
$db = $database->getConnection();

// Aquí puedes añadir tu lógica de backend para procesar reservaciones, panel admin, etc.
echo json_encode([
    "status" => "success",
    "message" => "El backend está configurado correctamente."
]);
