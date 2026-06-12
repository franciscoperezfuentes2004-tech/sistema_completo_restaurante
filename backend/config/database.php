<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        // Obtenemos variables de entorno (Render, Clever Cloud, etc)
        // Usamos valores por defecto para desarrollo local
        $this->host = getenv('DB_HOST') ?: 'birl5re8mmlx1ud9iap4-mysql.services.clever-cloud.com';
        $this->db_name = getenv('DB_NAME') ?: 'birl5re8mmlx1ud9iap4';
        $this->username = getenv('DB_USER') ?: 'uhmoggh0ntnh4fgd';
        $this->password = getenv('DB_PASSWORD') ?: 'fnuiRZ5GVyM471UjiNdi';
        $this->port = getenv('DB_PORT') ?: '3306';
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Sistema Inteligente de Autoconfiguración
            // Verifica y crea las tablas si no existen en la base de datos
            $this->initDatabase();
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            die("Error de conexión a la base de datos.");
        }

        return $this->conn;
    }

    private function initDatabase() {
        try {
            // 1. Array de queries para crear las tablas en el orden correcto
            $tablas = [
                "CREATE TABLE IF NOT EXISTS admins (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS categorias (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    orden INT DEFAULT 0,
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS platillos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    categoria_id INT NOT NULL,
                    nombre VARCHAR(150) NOT NULL,
                    descripcion TEXT,
                    precio DECIMAL(10,2) NOT NULL,
                    imagen_url VARCHAR(255),
                    destacado BOOLEAN DEFAULT FALSE,
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
                )",
                "CREATE TABLE IF NOT EXISTS promociones (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    titulo VARCHAR(150) NOT NULL,
                    descripcion TEXT,
                    descuento_porcentaje INT,
                    fecha_inicio DATE,
                    fecha_fin DATE,
                    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS testimonios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre_cliente VARCHAR(100) NOT NULL,
                    comentario TEXT NOT NULL,
                    calificacion INT CHECK(calificacion BETWEEN 1 AND 5),
                    estado ENUM('pendiente', 'aprobado', 'oculto') DEFAULT 'pendiente',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS reservaciones (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre_cliente VARCHAR(100) NOT NULL,
                    telefono VARCHAR(20) NOT NULL,
                    email VARCHAR(100),
                    fecha_reserva DATE NOT NULL,
                    hora_reserva TIME NOT NULL,
                    numero_personas INT NOT NULL,
                    comentarios_adicionales TEXT,
                    estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada') DEFAULT 'pendiente',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS configuracion (
                    clave VARCHAR(50) PRIMARY KEY,
                    valor TEXT NOT NULL
                )"
            ];

            // Ejecutamos cada query para crear las tablas
            foreach ($tablas as $query) {
                $this->conn->exec($query);
            }

            // 2. Insertar configuración por defecto si la tabla está recién creada
            $this->conn->exec("INSERT IGNORE INTO configuracion (clave, valor) VALUES 
                ('site_name', 'Aurum Restaurante'),
                ('primary_color', '#D32F2F'),
                ('whatsapp_number', '5215512345678')");

            // 3. Crear el administrador por defecto si no hay administradores
            $stmt = $this->conn->query("SELECT COUNT(*) FROM admins");
            if ($stmt && $stmt->fetchColumn() == 0) {
                // Generamos un hash seguro para la contraseña 'admin123'
                $default_password = password_hash('admin123', PASSWORD_BCRYPT);
                $insert_admin = $this->conn->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
                $insert_admin->execute(['admin', $default_password]);
            }
        } catch (PDOException $e) {
            // Silencioso: Si falla la creación (por permisos, por ejemplo), no rompemos la web
            error_log("Error en auto-setup de la DB: " . $e->getMessage());
        }
    }
}
