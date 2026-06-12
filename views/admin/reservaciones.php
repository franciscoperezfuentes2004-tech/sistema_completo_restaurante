<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Reservaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Gestión de Reservaciones</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--secundario">Calendario</button>
                    <button class="btn-admin btn-admin--primario">Nueva Reservación</button>
                </div>
            </header>

            <section class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha y Hora</th>
                            <th>Pax</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1044</td>
                            <td>Roberto Salas</td>
                            <td>2026-10-15 20:00</td>
                            <td>2</td>
                            <td>55 1234 5678</td>
                            <td><span style="color: var(--color-dorado);">Pendiente</span></td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario" style="color:#4CAF50; border-color:#4CAF50;">Confirmar</button>
                                    <button class="btn-admin btn-admin--peligro">Cancelar</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
