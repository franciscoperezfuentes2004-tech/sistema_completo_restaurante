<?php
header('Content-Type: application/json');
session_start();

// Validar que el usuario esté logueado antes de permitir acciones
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode([
        "status" => "error",
        "message" => "Sesión no autorizada."
    ]);
    exit;
}

// Requerir la conexión a la base de datos
require_once __DIR__ . '/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    $action = $_POST['action'] ?? '';

    if ($action === 'guardar_meta') {
        $meta = floatval($_POST['meta'] ?? 0);
        if ($meta <= 0) {
            echo json_encode([
                "status" => "error",
                "message" => "La meta debe ser un número positivo."
            ]);
            exit;
        }

        // Insertar o actualizar la meta de ventas
        $stmt = $db->prepare("
            INSERT INTO configuracion (clave, valor) 
            VALUES ('meta_ventas', :meta) 
            ON DUPLICATE KEY UPDATE valor = :meta
        ");
        $stmt->bindValue(':meta', strval($meta));
        $stmt->execute();

        echo json_encode([
            "status" => "success",
            "message" => "Meta de ventas actualizada correctamente."
        ]);
        exit;
    }

    echo json_encode([
        "status" => "error",
        "message" => "Acción no válida."
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error del servidor: " . $e->getMessage()
    ]);
}
