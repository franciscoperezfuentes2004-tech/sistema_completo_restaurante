<?php
// session_start();
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
                        01 Jun, 2026 - 12 Jun, 2026
                    </div>
                    <button class="admin-topbar__btn-pro">Exportar Reporte</button>
                    <div class="admin-topbar__notif">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <div class="admin-topbar__notif-dot"></div>
                    </div>
                    <div class="admin-topbar__user">
                        <div class="admin-topbar__avatar">A</div>
                        <span class="admin-topbar__user-name">Admin</span>
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
                            <div class="admin-card__subtitulo">Del 1 - 12 Jun, 2026</div>
                        </div>
                        <button class="admin-card__btn">Ver más</button>
                    </div>
                    <div class="chart-line-container">
                        <svg viewBox="0 0 300 120" preserveAspectRatio="none">
                            <!-- Grid lines -->
                            <line x1="0" y1="30" x2="300" y2="30" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            <line x1="0" y1="60" x2="300" y2="60" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            <line x1="0" y1="90" x2="300" y2="90" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            <!-- Ingresos Line -->
                            <polyline fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                points="0,90 30,70 60,80 90,45 120,55 150,35 180,50 210,30 240,40 270,20 300,35"/>
                            <!-- Gradient fill -->
                            <defs>
                                <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#7C3AED" stop-opacity="0.3"/>
                                    <stop offset="100%" stop-color="#7C3AED" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <polygon fill="url(#grad1)"
                                points="0,90 30,70 60,80 90,45 120,55 150,35 180,50 210,30 240,40 270,20 300,35 300,120 0,120"/>
                            <!-- Gastos Line -->
                            <polyline fill="none" stroke="#3B82F6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                points="0,95 30,85 60,90 90,75 120,80 150,70 180,65 210,75 240,60 270,65 300,55"/>
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
                            <div class="admin-card__subtitulo">Del 1 - 12 Jun, 2026</div>
                        </div>
                        <button class="admin-card__btn">Ver más</button>
                    </div>
                    <div class="donut-container">
                        <div class="donut-chart">
                            <svg viewBox="0 0 130 130">
                                <!-- Background circle -->
                                <circle cx="65" cy="65" r="50" stroke="rgba(255,255,255,0.05)" stroke-width="14" fill="none"/>
                                <!-- Comidas 42% -->
                                <circle cx="65" cy="65" r="50" stroke="#7C3AED" stroke-width="14" fill="none"
                                    stroke-dasharray="132 314" stroke-dashoffset="0" stroke-linecap="round"/>
                                <!-- Bebidas 28% -->
                                <circle cx="65" cy="65" r="50" stroke="#3B82F6" stroke-width="14" fill="none"
                                    stroke-dasharray="88 314" stroke-dashoffset="-132" stroke-linecap="round"/>
                                <!-- Postres 18% -->
                                <circle cx="65" cy="65" r="50" stroke="#F59E0B" stroke-width="14" fill="none"
                                    stroke-dasharray="57 314" stroke-dashoffset="-220" stroke-linecap="round"/>
                                <!-- Entradas 12% -->
                                <circle cx="65" cy="65" r="50" stroke="#22C55E" stroke-width="14" fill="none"
                                    stroke-dasharray="38 314" stroke-dashoffset="-277" stroke-linecap="round"/>
                            </svg>
                            <div class="donut-center">
                                <span class="donut-center__valor">248</span>
                                <span class="donut-center__cambio">+12.5%</span>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #7C3AED;"></div>
                                Comidas
                                <span class="donut-legend__pct">42%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #3B82F6;"></div>
                                Bebidas
                                <span class="donut-legend__pct">28%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #F59E0B;"></div>
                                Postres
                                <span class="donut-legend__pct">18%</span>
                            </div>
                            <div class="donut-legend__item">
                                <div class="donut-legend__dot" style="background: #22C55E;"></div>
                                Entradas
                                <span class="donut-legend__pct">12%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Próximas Reservaciones -->
                <div class="admin-card">
                    <div class="admin-card__header">
                        <div class="admin-card__titulo">Próximas Reservaciones</div>
                        <button class="admin-card__btn">Ver todas</button>
                    </div>
                    <div class="upcoming-list">
                        <div class="upcoming-item">
                            <span class="upcoming-item__fecha">12 Jun</span>
                            <span class="upcoming-item__nombre">Mesa VIP - Carlos M.</span>
                            <span class="upcoming-item__monto upcoming-item__monto--positivo">4 pax</span>
                        </div>
                        <div class="upcoming-item">
                            <span class="upcoming-item__fecha">12 Jun</span>
                            <span class="upcoming-item__nombre">Cumpleaños - Laura G.</span>
                            <span class="upcoming-item__monto upcoming-item__monto--pendiente">8 pax</span>
                        </div>
                        <div class="upcoming-item">
                            <span class="upcoming-item__fecha">13 Jun</span>
                            <span class="upcoming-item__nombre">Cena Empresarial</span>
                            <span class="upcoming-item__monto upcoming-item__monto--positivo">12 pax</span>
                        </div>
                        <div class="upcoming-item">
                            <span class="upcoming-item__fecha">14 Jun</span>
                            <span class="upcoming-item__nombre">Aniversario - Rodríguez</span>
                            <span class="upcoming-item__monto upcoming-item__monto--pendiente">2 pax</span>
                        </div>
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
                            <div class="admin-card__subtitulo">Del 1 - 12 Jun, 2026</div>
                        </div>
                        <button class="admin-card__btn">Ver Historial</button>
                    </div>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="admin-table__desc">
                                        <div class="admin-table__dot" style="background: #7C3AED;">CM</div>
                                        Carlos Mendoza
                                    </div>
                                </td>
                                <td>Jun 12</td>
                                <td class="admin-table__categoria">Comida</td>
                                <td class="admin-table__monto--positivo">+$2,320.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="admin-table__desc">
                                        <div class="admin-table__dot" style="background: #3B82F6;">LG</div>
                                        Laura Gómez
                                    </div>
                                </td>
                                <td>Jun 12</td>
                                <td class="admin-table__categoria">Bebidas</td>
                                <td class="admin-table__monto--positivo">+$580.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="admin-table__desc">
                                        <div class="admin-table__dot" style="background: #F59E0B;">PR</div>
                                        Proveedor Carnes
                                    </div>
                                </td>
                                <td>Jun 10</td>
                                <td class="admin-table__categoria">Insumos</td>
                                <td class="admin-table__monto--negativo">-$3,400.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="admin-table__desc">
                                        <div class="admin-table__dot" style="background: #22C55E;">RS</div>
                                        Roberto Salas
                                    </div>
                                </td>
                                <td>Jun 09</td>
                                <td class="admin-table__categoria">Evento</td>
                                <td class="admin-table__monto--positivo">+$8,900.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="admin-table__desc">
                                        <div class="admin-table__dot" style="background: #EF4444;">SL</div>
                                        Servicio de Limpieza
                                    </div>
                                </td>
                                <td>Jun 08</td>
                                <td class="admin-table__categoria">Gastos</td>
                                <td class="admin-table__monto--negativo">-$1,200.00</td>
                            </tr>
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
                            <span class="meta-card__porcentaje">68.5% de progreso. ¡Sigue así!</span>
                        </div>
                        <div class="meta-card__valor">$34,250 <span>de $50,000</span></div>
                        <div class="meta-card__barra">
                            <div class="meta-card__barra-fill" style="width: 68.5%;"></div>
                        </div>
                    </div>

                    <!-- Reporte Destacado -->
                    <div class="admin-card">
                        <div class="reporte-card__titulo">Reporte del Restaurante</div>
                        <p class="reporte-card__texto">Las ventas de este mes han incrementado un +23% en comparación al mes anterior. Las promociones activas están generando resultados positivos.</p>
                        <button class="reporte-card__btn">Ver Reporte Completo</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
