<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/admin.css?v=2.1">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Promociones</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">+ Nueva Promoción</button>
                </div>
            </header>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descuento</th>
                            <th>Válido Hasta</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cena Romántica</td>
                            <td>15%</td>
                            <td>2026-07-15</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Activo</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Happy Hour</td>
                            <td>20%</td>
                            <td>2026-08-01</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Activo</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2x1 Postres</td>
                            <td>50%</td>
                            <td>2026-05-30</td>
                            <td><span style="color: var(--admin-text-secondary); font-weight: 600;">Inactivo</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
