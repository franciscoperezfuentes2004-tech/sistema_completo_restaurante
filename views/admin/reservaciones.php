<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Reservaciones</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--secundario">📅 Calendario</button>
                    <button class="btn-admin btn-admin--primario">+ Nueva Reservación</button>
                </div>
            </header>

            <div class="admin-table-container">
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
                            <td>101</td>
                            <td>Laura Martínez</td>
                            <td>2026-06-14 20:00</td>
                            <td>4</td>
                            <td>+52 55 1234 5678</td>
                            <td><span style="color: var(--admin-warning); font-weight: 600;">Pendiente</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario" style="color: var(--admin-success); border-color: var(--admin-success);">Confirmar</button>
                                <button class="btn-admin btn-admin--peligro">Cancelar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td>Fernando Ruiz</td>
                            <td>2026-06-14 21:30</td>
                            <td>2</td>
                            <td>+52 55 9876 5432</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Confirmada</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario" style="color: var(--admin-success); border-color: var(--admin-success);">Confirmar</button>
                                <button class="btn-admin btn-admin--peligro">Cancelar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>103</td>
                            <td>Sofía Hernández</td>
                            <td>2026-06-15 14:00</td>
                            <td>6</td>
                            <td>+52 33 5555 1234</td>
                            <td><span style="color: var(--admin-warning); font-weight: 600;">Pendiente</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario" style="color: var(--admin-success); border-color: var(--admin-success);">Confirmar</button>
                                <button class="btn-admin btn-admin--peligro">Cancelar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>104</td>
                            <td>Diego Morales</td>
                            <td>2026-06-15 19:00</td>
                            <td>3</td>
                            <td>+52 81 4444 7890</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Confirmada</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario" style="color: var(--admin-success); border-color: var(--admin-success);">Confirmar</button>
                                <button class="btn-admin btn-admin--peligro">Cancelar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
