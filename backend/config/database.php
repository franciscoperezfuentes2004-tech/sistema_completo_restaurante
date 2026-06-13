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
                )",
                "CREATE TABLE IF NOT EXISTS transacciones (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    descripcion VARCHAR(150) NOT NULL,
                    fecha DATE NOT NULL,
                    categoria VARCHAR(50) NOT NULL,
                    tipo ENUM('ingreso', 'gasto') NOT NULL,
                    monto DECIMAL(10,2) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
                ('whatsapp_number', '5215512345678'),
                ('meta_ventas', '50000'),
                ('reporte_texto', 'Las ventas de este mes han incrementado un +23% en comparación al mes anterior. Las promociones activas están generando resultados positivos.')");

            // 3. Crear el administrador por defecto si no hay administradores
            $stmt = $this->conn->query("SELECT COUNT(*) FROM admins");
            if ($stmt && $stmt->fetchColumn() == 0) {
                // Generamos un hash seguro para la contraseña 'admin123'
                $default_password = password_hash('admin123', PASSWORD_BCRYPT);
                $insert_admin = $this->conn->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
                $insert_admin->execute(['admin', $default_password]);
            }

            // 4. Crear transacciones semilla si está vacía
            $stmt_trans = $this->conn->query("SELECT COUNT(*) FROM transacciones");
            if ($stmt_trans && $stmt_trans->fetchColumn() == 0) {
                // Insertamos datos reales e históricos de los últimos 12 días
                // Los montos históricos coinciden aproximadamente con el gráfico lineal del mockup
                $transacciones_semilla = [
                    // Recientes
                    ['Carlos Mendoza', date('Y-m-d', strtotime('-0 days')), 'Comida', 'ingreso', 2320.00],
                    ['Laura Gómez', date('Y-m-d', strtotime('-0 days')), 'Bebidas', 'ingreso', 580.00],
                    ['Proveedor Carnes', date('Y-m-d', strtotime('-2 days')), 'Insumos', 'gasto', 3400.00],
                    ['Roberto Salas', date('Y-m-d', strtotime('-3 days')), 'Evento', 'ingreso', 8900.00],
                    ['Servicio de Limpieza', date('Y-m-d', strtotime('-4 days')), 'Gastos', 'gasto', 1200.00],
                    
                    // Histórico para poblar gráfico (últimos 12 días)
                    ['Venta Diaria', date('Y-m-d', strtotime('-11 days')), 'Comida', 'ingreso', 1200.00],
                    ['Gastos Luz', date('Y-m-d', strtotime('-11 days')), 'Gastos', 'gasto', 1000.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-10 days')), 'Comida', 'ingreso', 2500.00],
                    ['Gastos Agua', date('Y-m-d', strtotime('-10 days')), 'Gastos', 'gasto', 500.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-9 days')), 'Comida', 'ingreso', 1800.00],
                    ['Gastos Ingredientes', date('Y-m-d', strtotime('-9 days')), 'Insumos', 'gasto', 800.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-8 days')), 'Comida', 'ingreso', 4200.00],
                    ['Gastos Proveedor Verduras', date('Y-m-d', strtotime('-8 days')), 'Insumos', 'gasto', 1500.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-7 days')), 'Comida', 'ingreso', 3100.00],
                    ['Gastos Gas', date('Y-m-d', strtotime('-7 days')), 'Gastos', 'gasto', 1200.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-6 days')), 'Comida', 'ingreso', 5500.00],
                    ['Gastos Mantenimiento', date('Y-m-d', strtotime('-6 days')), 'Gastos', 'gasto', 2000.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-5 days')), 'Comida', 'ingreso', 3800.00],
                    ['Gastos Limpieza', date('Y-m-d', strtotime('-5 days')), 'Gastos', 'gasto', 1100.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-4 days')), 'Comida', 'ingreso', 6200.00],
                    ['Compra Platos', date('Y-m-d', strtotime('-4 days')), 'Insumos', 'gasto', 1800.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-3 days')), 'Comida', 'ingreso', 4800.00],
                    ['Pago Nómina Extra', date('Y-m-d', strtotime('-3 days')), 'Gastos', 'gasto', 2500.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-2 days')), 'Comida', 'ingreso', 7100.00],
                    ['Venta Diaria', date('Y-m-d', strtotime('-1 days')), 'Comida', 'ingreso', 8300.00],
                    ['Gastos Publicidad', date('Y-m-d', strtotime('-1 days')), 'Gastos', 'gasto', 1900.00],
                    
                    // Categorías para Dona (Postres, Entradas)
                    ['Mesa Postres', date('Y-m-d', strtotime('-2 days')), 'Postres', 'ingreso', 1200.00],
                    ['Mesa Entradas', date('Y-m-d', strtotime('-1 days')), 'Entradas', 'ingreso', 900.00]
                ];
                
                $insert_trans = $this->conn->prepare("INSERT INTO transacciones (descripcion, fecha, categoria, tipo, monto) VALUES (?, ?, ?, ?, ?)");
                foreach ($transacciones_semilla as $t) {
                    $insert_trans->execute($t);
                }
            }

            // 5. Crear reservaciones semilla si está vacía
            $stmt_res = $this->conn->query("SELECT COUNT(*) FROM reservaciones");
            if ($stmt_res && $stmt_res->fetchColumn() == 0) {
                $reservaciones_semilla = [
                    ['Carlos Mendoza', '+52 55 1234 5678', 'carlos@mail.com', date('Y-m-d'), '20:00:00', 4, 'Mesa VIP', 'confirmada'],
                    ['Laura Gómez', '+52 55 9876 5432', 'laura@mail.com', date('Y-m-d'), '21:30:00', 8, 'Cumpleaños', 'pendiente'],
                    ['Cena Empresarial', '+52 33 5555 1234', 'empresa@mail.com', date('Y-m-d', strtotime('+1 days')), '14:00:00', 12, 'Reservación grupal', 'confirmada'],
                    ['Familia Rodríguez', '+52 81 4444 7890', 'rodriguez@mail.com', date('Y-m-d', strtotime('+2 days')), '19:00:00', 2, 'Aniversario', 'pendiente']
                ];
                
                $insert_res = $this->conn->prepare("INSERT INTO reservaciones (nombre_cliente, telefono, email, fecha_reserva, hora_reserva, numero_personas, comentarios_adicionales, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                foreach ($reservaciones_semilla as $r) {
                    $insert_res->execute($r);
                }
            }
        } catch (PDOException $e) {
            // Silencioso: Si falla la creación (por permisos, por ejemplo), no rompemos la web
            error_log("Error en auto-setup de la DB: " . $e->getMessage());
        }
    }
}
