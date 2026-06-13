<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías | Admin</title>
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
                <h1>Categorías</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">+ Nueva Categoría</button>
                </div>
            </header>

            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Orden</th>
                            <th>Platillos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Desayunos</td>
                            <td>1</td>
                            <td>12</td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Comidas</td>
                            <td>2</td>
                            <td>18</td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bebidas</td>
                            <td>3</td>
                            <td>9</td>
                            <td>
                                <button class="btn-admin btn-admin--secundario">Editar</button>
                                <button class="btn-admin btn-admin--peligro">Eliminar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Postres</td>
                            <td>4</td>
                            <td>7</td>
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
