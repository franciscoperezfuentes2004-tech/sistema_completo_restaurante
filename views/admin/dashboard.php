<?php
// session_start();
// Si no hay sesión, redirigir a login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Panel de Control</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">Exportar Reporte</button>
                </div>
            </header>

            <section class="admin-grid">
                <div class="admin-card">
                    <h3 class="admin-card__titulo">Reservaciones Hoy</h3>
                    <p class="admin-card__valor">14</p>
                </div>
                <div class="admin-card">
                    <h3 class="admin-card__titulo">Platillos Activos</h3>
                    <p class="admin-card__valor">32</p>
                </div>
                <div class="admin-card">
                    <h3 class="admin-card__titulo">Nuevos Testimonios</h3>
                    <p class="admin-card__valor">5</p>
                </div>
                <div class="admin-card">
                    <h3 class="admin-card__titulo">Promociones Vigentes</h3>
                    <p class="admin-card__valor">2</p>
                </div>
            </section>

            <section class="admin-table-container" style="margin-top: 30px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Hora</th>
                            <th>Personas</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1042</td>
                            <td>Carlos Mendoza</td>
                            <td>19:00</td>
                            <td>2</td>
                            <td><span style="color: #4CAF50;">Confirmada</span></td>
                        </tr>
                        <tr>
                            <td>#1043</td>
                            <td>Laura Gómez</td>
                            <td>20:30</td>
                            <td>4</td>
                            <td><span style="color: var(--color-dorado);">Pendiente</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
