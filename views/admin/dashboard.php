<?php
session_start();

// Control de Acceso
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Requerir conexión a la base de datos
require_once __DIR__ . '/../../backend/config/database.php';
$database = new Database();
$db = $database->getConnection();

// 1. Obtener meta de ventas de la configuración
$stmt_meta = $db->prepare("SELECT valor FROM configuracion WHERE clave = 'meta_ventas' LIMIT 1");
$stmt_meta->execute();
$meta_ventas = 50000; // valor por defecto
if ($stmt_meta->rowCount() > 0) {
    $meta_ventas = floatval($stmt_meta->fetch(PDO::FETCH_ASSOC)['valor']);
}

// 2. Obtener reporte de texto
$stmt_reporte = $db->prepare("SELECT valor FROM configuracion WHERE clave = 'reporte_texto' LIMIT 1");
$stmt_reporte->execute();
$reporte_texto = "Las ventas de este mes han incrementado un +23% en comparación al mes anterior. Las promociones activas están generando resultados positivos.";
if ($stmt_reporte->rowCount() > 0) {
    $reporte_texto = $stmt_reporte->fetch(PDO::FETCH_ASSOC)['valor'];
}

// 3. Obtener suma de ventas (pedidos completados) del mes actual
$stmt_ventas_mes = $db->prepare("
    SELECT SUM(total) as total 
    FROM pedidos 
    WHERE estado = 'entregado' 
      AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
      AND YEAR(created_at) = YEAR(CURRENT_DATE())
");
$stmt_ventas_mes->execute();
$total_ingresos_mes = floatval($stmt_ventas_mes->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

// Calcular porcentaje de meta de ventas
$porcentaje_meta = $meta_ventas > 0 ? min(100, round(($total_ingresos_mes / $meta_ventas) * 100, 1)) : 0;

// 4. Obtener distribución de categorías para los pedidos entregados (Donut Chart)
$stmt_dist = $db->prepare("
    SELECT c.nombre as categoria, SUM(pd.cantidad) as total_qty
    FROM pedido_detalles pd
    JOIN platillos p ON pd.platillo_id = p.id
    JOIN categorias c ON p.categoria_id = c.id
    JOIN pedidos ped ON pd.pedido_id = ped.id
    WHERE ped.estado = 'entregado'
    GROUP BY c.nombre
");
$stmt_dist->execute();
$distribucion = $stmt_dist->fetchAll(PDO::FETCH_ASSOC);

$total_pedidos = 0;
$pedidos_por_cat = [
    'Comidas' => 0,
    'Bebidas' => 0,
    'Postres' => 0,
    'Entradas' => 0
];

foreach ($distribucion as $row) {
    $cat = $row['categoria'];
    $qty = intval($row['total_qty']);
    $total_pedidos += $qty;
    if ($cat === 'Comida' || $cat === 'Comidas' || $cat === 'Desayunos') {
        $pedidos_por_cat['Comidas'] += $qty;
    } elseif ($cat === 'Bebida' || $cat === 'Bebidas') {
        $pedidos_por_cat['Bebidas'] += $qty;
    } elseif ($cat === 'Postres' || $cat === 'Postre') {
        $pedidos_por_cat['Postres'] += $qty;
    } elseif ($cat === 'Entradas' || $cat === 'Entrada') {
        $pedidos_por_cat['Entradas'] += $qty;
    }
}

// Calcular porcentajes
$pct_comidas = $total_pedidos > 0 ? round(($pedidos_por_cat['Comidas'] / $total_pedidos) * 100) : 0;
$pct_bebidas = $total_pedidos > 0 ? round(($pedidos_por_cat['Bebidas'] / $total_pedidos) * 100) : 0;
$pct_postres = $total_pedidos > 0 ? round(($pedidos_por_cat['Postres'] / $total_pedidos) * 100) : 0;
$pct_entradas = $total_pedidos > 0 ? round(($pedidos_por_cat['Entradas'] / $total_pedidos) * 100) : 0;

$circunferencia = 314;
$len_comidas = round($circunferencia * ($pct_comidas / 100));
$len_bebidas = round($circunferencia * ($pct_bebidas / 100));
$len_postres = round($circunferencia * ($pct_postres / 100));
$len_entradas = round($circunferencia * ($pct_entradas / 100));

$offset_comidas = 0;
$offset_bebidas = -$len_comidas;
$offset_postres = -($len_comidas + $len_bebidas);
$offset_entradas = -($len_comidas + $len_bebidas + $len_postres);

// 5. Obtener ingresos y gastos diarios de los últimos 12 días (Line Chart)
$dias_grafico = [];
for ($i = 11; $i >= 0; $i--) {
    $dias_grafico[] = date('Y-m-d', strtotime("-$i days"));
}

$ingresos_por_dia = array_fill_keys($dias_grafico, 0.0);
$gastos_por_dia = array_fill_keys($dias_grafico, 0.0);

$fecha_inicio_rango = $dias_grafico[0];
$fecha_fin_rango = $dias_grafico[11];

// 5.1 Ingresos (pedidos entregados)
$stmt_ingresos_chart = $db->prepare("
    SELECT DATE(created_at) as fecha_dia, SUM(total) as total_dia
    FROM pedidos
    WHERE estado = 'entregado'
      AND DATE(created_at) BETWEEN :inicio AND :fin
    GROUP BY DATE(created_at)
");
$stmt_ingresos_chart->execute([
    ':inicio' => $fecha_inicio_rango,
    ':fin' => $fecha_fin_rango
]);
while ($row = $stmt_ingresos_chart->fetch(PDO::FETCH_ASSOC)) {
    $fecha = $row['fecha_dia'];
    if (isset($ingresos_por_dia[$fecha])) {
        $ingresos_por_dia[$fecha] = floatval($row['total_dia']);
    }
}

// 5.2 Gastos (transacciones gasto)
$stmt_gastos_chart = $db->prepare("
    SELECT fecha, SUM(monto) as total_dia
    FROM transacciones
    WHERE tipo = 'gasto'
      AND fecha BETWEEN :inicio AND :fin
    GROUP BY fecha
");
$stmt_gastos_chart->execute([
    ':inicio' => $fecha_inicio_rango,
    ':fin' => $fecha_fin_rango
]);
while ($row = $stmt_gastos_chart->fetch(PDO::FETCH_ASSOC)) {
    $fecha = $row['fecha'];
    if (isset($gastos_por_dia[$fecha])) {
        $gastos_por_dia[$fecha] = floatval($row['total_dia']);
    }
}

// Encontrar el valor máximo para normalizar la escala vertical (Y)
$max_valor = 1000.0;
foreach ($ingresos_por_dia as $val) {
    if ($val > $max_valor) $max_valor = $val;
}
foreach ($gastos_por_dia as $val) {
    if ($val > $max_valor) $max_valor = $val;
}
$max_valor *= 1.15; // margen superior

$puntos_ingresos = [];
$puntos_gastos = [];

$x = 0;
$intervalo_x = 300 / 11;

foreach ($dias_grafico as $dia) {
    $ing = $ingresos_por_dia[$dia];
    $gas = $gastos_por_dia[$dia];
    
    $y_ing = 100 - ($ing / $max_valor) * 80;
    $y_gas = 100 - ($gas / $max_valor) * 80;
    
    $puntos_ingresos[] = "$x,$y_ing";
    $puntos_gastos[] = "$x,$y_gas";
    
    $x += $intervalo_x;
}

$str_puntos_ingresos = implode(" ", $puntos_ingresos);
$str_puntos_gastos = implode(" ", $puntos_gastos);

// 6. Obtener las próximas 4 reservaciones
$stmt_res = $db->prepare("
    SELECT nombre_cliente, fecha_reserva, numero_personas, estado 
    FROM reservaciones 
    WHERE fecha_reserva >= CURRENT_DATE() 
      AND estado != 'cancelada'
    ORDER BY fecha_reserva ASC, hora_reserva ASC 
    LIMIT 4
");
$stmt_res->execute();
$reservaciones_proximas = $stmt_res->fetchAll(PDO::FETCH_ASSOC);

// 7. Obtener los últimos 5 pedidos
$stmt_pedidos_recent = $db->prepare("
    SELECT id, nombre_cliente, tipo_entrega, total, estado, created_at 
    FROM pedidos 
    ORDER BY created_at DESC, id DESC 
    LIMIT 5
");
$stmt_pedidos_recent->execute();
$pedidos_recientes = $stmt_pedidos_recent->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/admin.css?v=2.1">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <!-- ── Top Bar ── -->
            <div class="admin-topbar">
                <div class="admin-topbar__izq">
                    <h1>Dashboard</h1>
                    <p>Bienvenido, aquí tienes el resumen de tu restaurante.</p>
                </div>
                <div class="admin-topbar__der">
                    <div class="admin-topbar__fecha">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?php echo date('d M', strtotime($fecha_inicio_rango)) . ' - ' . date('d M, Y', strtotime($fecha_fin_rango)); ?>
                    </div>
                    <button class="admin-topbar__btn-pro">Exportar Reporte</button>
                    <div class="admin-topbar__notif">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <div class="admin-topbar__notif-dot"></div>
                    </div>
                    <div class="admin-topbar__user">
                        <div class="admin-topbar__avatar"><?php echo strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)); ?></div>
                        <span class="admin-topbar__user-name"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                    </div>
                </div>
            </div>

            <!-- ══ Fila 1: 3 tarjetas ══ -->
            <div class="admin-grid-row admin-grid-row--3">

                <!-- Card 1: Resumen de Ventas (Line Chart) -->
                <div class="admin-card">
                    <div class="admin-card__header">
                        <div>
                            <div class="admin-card__titulo">Resumen de Ventas</div>
                            <div class="admin-card__subtitulo">Del <?php echo date('d M', strtotime($fecha_inicio_rango)) . ' - ' . date('d M, Y', strtotime($fecha_fin_rango)); ?></div>
                        </div>
                        <button class="admin-card__btn">Ver más</button>
                    </div>
                    <div class="chart-line-container">
                        <svg viewBox="0 0 300 120" preserveAspectRatio="none">
                            <!-- Grid lines -->
                            <line x1="0" y1="30" x2="300" y2="30" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            <line x1="0" y1="60" x2="300" y2="60" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            <line x1="0" y1="90" x2="300" y2="90" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            
                            <!-- Relleno Gradiente para Ingresos -->
                            <defs>
                                <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#7C3AED" stop-opacity="0.3"/>
                                    <stop offset="100%" stop-color="#7C3AED" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <polygon fill="url(#grad1)" points="0,120 <?php echo $str_puntos_ingresos; ?> 300,120"/>

                            <!-- Ingresos Line -->
                            <polyline fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                points="<?php echo $str_puntos_ingresos; ?>"/>
                            
                            <!-- Gastos Line -->
                            <polyline fill="none" stroke="#3B82F6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                points="<?php echo $str_puntos_gastos; ?>"/>
                        </svg>
                    </div>
                    <div class="chart-legend">
                        <div class="chart-legend__item">
                            <div class="chart-legend__dot" style="background: #7C3AED;"></div>
                            Ingresos
                        </div>
                        <div class="chart-legend__item">
                            <div class="chart-legend__dot" style="background: #3B82F6;"></div>
                            Gastos
                        </div>
                    </div>
                </div>

                <!-- Card 2: Distribución de Pedidos (Donut) -->
                <div class="admin-card">
                    <div class="admin-card__header">
                        <div>
                            <div class="admin-card__titulo">Pedidos</div>
                            <div class="admin-card__subtitulo">Del <?php echo date('d M', strtotime($fecha_inicio_rango)) . ' - ' . date('d M, Y', strtotime($fecha_fin_rango)); ?></div>
                        </div>
                        <button class="admin-card__btn">Ver más</button>
                    </div>
                    <div class="donut-container">
                        <div class="donut-chart">
                            <svg viewBox="0 0 130 130">
                                <!-- Background circle -->
                                <circle cx="65" cy="65" r="50" stroke="rgba(255,255,255,0.05)" stroke-width="14" fill="none"/>
                                <?php if ($total_pedidos === 0): ?>
                                    <!-- Círculo vacío por defecto si no hay pedidos -->
                                    <circle cx="65" cy="65" r="50" stroke="rgba(255, 255, 255, 0.05)" stroke-width="14" fill="none"/>
                                <?php else: ?>
                                    <!-- Comidas -->
                                    <circle cx="65" cy="65" r="50" stroke="#7C3AED" stroke-width="14" fill="none"
                                        stroke-dasharray="<?php echo $len_comidas; ?> 314" stroke-dashoffset="<?php echo $offset_comidas; ?>" stroke-linecap="round"/>
                                    <!-- Bebidas -->
                                    <circle cx="65" cy="65" r="50" stroke="#3B82F6" stroke-width="14" fill="none"
                                        stroke-dasharray="<?php echo $len_bebidas; ?> 314" stroke-dashoffset="<?php echo $offset_bebidas; ?>" stroke-linecap="round"/>
                                    <!-- Postres -->
                                    <circle cx="65" cy="65" r="50" stroke="#F59E0B" stroke-width="14" fill="none"
                                        stroke-dasharray="<?php echo $len_postres; ?> 314" stroke-dashoffset="<?php echo $offset_postres; ?>" stroke-linecap="round"/>
                                    <!-- Entradas -->
                                    <circle cx="65" cy="65" r="50" stroke="#22C55E" stroke-width="14" fill="none"
                                        stroke-dasharray="<?php echo $len_entradas; ?> 314" stroke-dashoffset="<?php echo $offset_entradas; ?>" stroke-linecap="round"/>
                                <?php endif; ?>
                            </svg>
                            <div class="donut-center">
                                <span class="donut-center__valor"><?php echo $total_pedidos; ?></span>
                                <span class="donut-center__cambio">items</span>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #7C3AED;"></div>
                                Comidas
                                <span class="donut-legend__pct"><?php echo $pct_comidas; ?>%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #3B82F6;"></div>
                                Bebidas
                                <span class="donut-legend__pct"><?php echo $pct_bebidas; ?>%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #F59E0B;"></div>
                                Postres
                                <span class="donut-legend__pct"><?php echo $pct_postres; ?>%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #22C55E;"></div>
                                Entradas
                                <span class="donut-legend__pct"><?php echo $pct_entradas; ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Próximas Reservaciones -->
                <div class="admin-card">
                    <div class="admin-card__header">
                        <div class="admin-card__titulo">Próximas Reservaciones</div>
                        <a href="reservaciones.php" class="admin-card__btn">Ver todas</a>
                    </div>
                    <div class="upcoming-list">
                        <?php if (empty($reservaciones_proximas)): ?>
                            <div class="upcoming-item" style="justify-content: center; padding: 36px 0;">
                                <span class="upcoming-item__nombre" style="color: var(--admin-text-muted); text-align: center;">No hay reservaciones próximas</span>
                            </div>
                        <?php else: ?>
                            <?php foreach ($reservaciones_proximas as $res): ?>
                                <div class="upcoming-item">
                                    <span class="upcoming-item__fecha"><?php echo date('d M', strtotime($res['fecha_reserva'])); ?></span>
                                    <span class="upcoming-item__nombre"><?php echo htmlspecialchars($res['nombre_cliente']); ?></span>
                                    <?php
                                    $estado_class = 'upcoming-item__monto--pendiente';
                                    if ($res['estado'] === 'confirmada' || $res['estado'] === 'completada') {
                                        $estado_class = 'upcoming-item__monto--positivo';
                                    } elseif ($res['estado'] === 'cancelada') {
                                        $estado_class = 'upcoming-item__monto--negativo';
                                    }
                                    ?>
                                    <span class="upcoming-item__monto <?php echo $estado_class; ?>"><?php echo intval($res['numero_personas']); ?> pax</span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ══ Fila 2: Tabla + Cards laterales ══ -->
            <div class="admin-grid-row admin-grid-row--2">

                <!-- Tabla: Pedidos Recientes -->
                <div class="admin-table-container">
                    <div class="admin-card__header" style="margin-bottom: 20px;">
                        <div>
                            <div class="admin-card__titulo">Pedidos Recientes</div>
                            <div class="admin-card__subtitulo">Del <?php echo date('d M', strtotime($fecha_inicio_rango)) . ' - ' . date('d M, Y', strtotime($fecha_fin_rango)); ?></div>
                        </div>
                        <button class="admin-card__btn">Ver Historial</button>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Tipo de Entrega</th>
                                <th>Monto e Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pedidos_recientes)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 24px 0; color: var(--admin-text-muted);">No hay pedidos recientes</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pedidos_recientes as $ped): ?>
                                    <?php
                                    // Obtener iniciales para el avatar
                                    $words = explode(" ", $ped['nombre_cliente']);
                                    $iniciales = "";
                                    foreach ($words as $w) {
                                        $iniciales .= mb_substr($w, 0, 1);
                                        if (mb_strlen($iniciales) >= 2) break;
                                    }
                                    $iniciales = strtoupper($iniciales);
                                    
                                    // Color de fondo para avatar según tipo de entrega
                                    $avatar_bg = '#7C3AED'; // mesa (púrpura)
                                    if ($ped['tipo_entrega'] === 'domicilio') {
                                        $avatar_bg = '#3B82F6'; // domicilio (azul)
                                    } elseif ($ped['tipo_entrega'] === 'llevar') {
                                        $avatar_bg = '#F59E0B'; // llevar (naranja)
                                    }
                                    
                                    // Formatear tipo de entrega en español
                                    $tipo_str = 'Mesa';
                                    if ($ped['tipo_entrega'] === 'domicilio') $tipo_str = 'A Domicilio';
                                    elseif ($ped['tipo_entrega'] === 'llevar') $tipo_str = 'Para Llevar';
                                    
                                    // Clase de monto según estado
                                    $monto_class = 'admin-table__monto--positivo';
                                    if ($ped['estado'] === 'cancelado') {
                                        $monto_class = 'admin-table__monto--negativo';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="admin-table__desc">
                                                <div class="admin-table__dot" style="background: <?php echo $avatar_bg; ?>;"><?php echo htmlspecialchars($iniciales); ?></div>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($ped['nombre_cliente']); ?></strong>
                                                    <div style="font-size: 11px; color: var(--admin-text-muted);">Pedido #<?php echo $ped['id']; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo date('M d, H:i', strtotime($ped['created_at'])); ?></td>
                                        <td class="admin-table__categoria"><?php echo htmlspecialchars($tipo_str); ?></td>
                                        <td class="<?php echo $monto_class; ?>">
                                            $<?php echo number_format($ped['total'], 2); ?>
                                            <span style="font-size: 11px; display: block; font-weight: 600; color: <?php echo $ped['estado'] === 'entregado' ? 'var(--admin-success)' : ($ped['estado'] === 'cancelado' ? 'var(--admin-danger)' : 'var(--admin-warning)'); ?>;">
                                                <?php echo ucfirst($ped['estado']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Columna Derecha (stacked) -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <!-- Meta de Ventas -->
                    <div class="admin-card">
                        <div class="admin-card__header">
                            <div class="admin-card__titulo">Meta de Ventas</div>
                            <button class="meta-card__edit-btn">Editar</button>
                        </div>
                        <div class="meta-card__info">
                            <span class="meta-card__porcentaje"><?php echo $porcentaje_meta; ?>% de progreso. ¡Sigue así!</span>
                        </div>
                        <div class="meta-card__valor">$<?php echo number_format($total_ingresos_mes); ?> <span>de $<?php echo number_format($meta_ventas); ?></span></div>
                        <div class="meta-card__barra">
                            <div class="meta-card__barra-fill" style="width: <?php echo $porcentaje_meta; ?>%;"></div>
                        </div>
                    </div>

                    <!-- Reporte Destacado -->
                    <div class="admin-card">
                        <div class="reporte-card__titulo">Reporte del Restaurante</div>
                        <p class="reporte-card__texto"><?php echo htmlspecialchars($reporte_texto); ?></p>
                        <button class="reporte-card__btn">Ver Reporte Completo</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Script para interactividad de la meta de ventas -->
    <script>
    document.querySelector('.meta-card__edit-btn').addEventListener('click', function() {
        const goal = prompt('Ingresa la nueva meta de ventas mensual ($):', '<?php echo intval($meta_ventas); ?>');
        if (goal !== null && !isNaN(goal) && parseFloat(goal) > 0) {
            const formData = new FormData();
            formData.append('action', 'guardar_meta');
            formData.append('meta', parseFloat(goal));

            fetch('../../backend/api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert('Error al guardar la meta de ventas: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar conectarse al servidor.');
            });
        }
    });
    </script>
</body>
</html>
