<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platillos | Admin</title>
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
                <h1>Platillos</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">+ Nuevo Platillo</button>
                </div>
            </header>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="../../assets/img/placeholder.png" alt="Salmón Glaseado" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                            </td>
                            <td>Salmón Glaseado</td>
                            <td>Comidas</td>
                            <td>$350</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Activo</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="../../assets/img/placeholder.png" alt="Esfera de Chocolate" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                            </td>
                            <td>Esfera de Chocolate</td>
                            <td>Postres</td>
                            <td>$180</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Activo</span></td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="../../assets/img/placeholder.png" alt="Taco de Wagyu" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                            </td>
                            <td>Taco de Wagyu</td>
                            <td>Comidas</td>
                            <td>$290</td>
                            <td><span style="color: var(--admin-success); font-weight: 600;">Activo</span></td>
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
