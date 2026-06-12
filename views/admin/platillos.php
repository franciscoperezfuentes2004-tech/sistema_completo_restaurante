<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Platillos</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Gestión de Platillos</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">Nuevo Platillo</button>
                </div>
            </header>

            <section class="admin-table-container">
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
                            <td><img src="../../assets/img/platillo1.jpg" alt="Salmon" width="50" style="border-radius: 4px;"></td>
                            <td>Salmón glaseado</td>
                            <td>Comidas</td>
                            <td>$350</td>
                            <td><span style="color: #4CAF50;">Activo</span></td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario">Editar</button>
                                    <button class="btn-admin btn-admin--peligro">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../../assets/img/platillo2.jpg" alt="Postre" width="50" style="border-radius: 4px;"></td>
                            <td>Esfera de Chocolate</td>
                            <td>Postres</td>
                            <td>$180</td>
                            <td><span style="color: #4CAF50;">Activo</span></td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario">Editar</button>
                                    <button class="btn-admin btn-admin--peligro">Eliminar</button>
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
