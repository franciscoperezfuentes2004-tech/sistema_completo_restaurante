<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Categorías</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Gestión de Categorías</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nueva Categoría
                    </button>
                </div>
            </header>

            <section class="admin-table-container">
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
                            <td>8</td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario">Editar</button>
                                    <button class="btn-admin btn-admin--peligro">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Comidas</td>
                            <td>2</td>
                            <td>15</td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario">Editar</button>
                                    <button class="btn-admin btn-admin--peligro">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bebidas</td>
                            <td>3</td>
                            <td>9</td>
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
