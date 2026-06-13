<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonios | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/admin.css?v=2.0">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Testimonios</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">+ Nuevo Testimonio</button>
                </div>
            </header>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Comentario</th>
                            <th>Calificación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>María González</td>
                            <td>La mejor experiencia gastronómica que he tenido en…</td>
                            <td>⭐⭐⭐⭐⭐</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Aprobado</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Ocultar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Carlos Mendoza</td>
                            <td>Excelente servicio y ambiente muy agradable para…</td>
                            <td>⭐⭐⭐⭐</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Aprobado</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Ocultar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ana López</td>
                            <td>Los postres son increíbles, especialmente la esfera…</td>
                            <td>⭐⭐⭐⭐⭐</td>
                            <td><span style="color: var(--admin-warning); font-weight: 600;">Pendiente</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Ocultar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Roberto Díaz</td>
                            <td>Buena comida pero el tiempo de espera fue un poco…</td>
                            <td>⭐⭐⭐</td>
                            <td><span style="color: var(--admin-warning); font-weight: 600;">Pendiente</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Ocultar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
