<?php
session_start();

// Si la petición no es POST, redirigir al login
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/admin/login.php');
    exit;
}

// Requerir la conexión a la base de datos (esto también ejecuta la auto-creación de tablas)
require_once __DIR__ . '/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header('Location: ../views/admin/login.php?error=campos_vacios');
        exit;
    }

    // Buscar al usuario en la base de datos
    $stmt = $db->prepare("SELECT id, username, password_hash FROM admins WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña con el hash
        if (password_verify($password, $admin['password_hash'])) {
            // Contraseña correcta: Iniciar sesión
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            
            // Redirigir al dashboard
            header('Location: ../views/admin/dashboard.php');
            exit;
        } else {
            // Contraseña incorrecta
            header('Location: ../views/admin/login.php?error=credenciales_invalidas');
            exit;
        }
    } else {
        // Usuario no encontrado
        header('Location: ../views/admin/login.php?error=credenciales_invalidas');
        exit;
    }

} catch(PDOException $e) {
    // Si hay un error de conexión, mostrar un mensaje o redirigir
    error_log("Auth Error: " . $e->getMessage());
    header('Location: ../views/admin/login.php?error=error_sistema');
    exit;
}
