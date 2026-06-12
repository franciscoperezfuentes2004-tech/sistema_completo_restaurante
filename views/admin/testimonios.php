<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Testimonios</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Testimonios</h1>
                <div class="admin-header__acciones">
                    <button class="btn-admin btn-admin--primario">Agregar Testimonio</button>
                </div>
            </header>

            <section class="admin-table-container">
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
                            <td>"La mejor experiencia culinaria de mi vida..."</td>
                            <td>⭐⭐⭐⭐⭐</td>
                            <td><span style="color: #4CAF50;">Aprobado</span></td>
                            <td>
                                <div class="acciones-tabla">
                                    <button class="btn-admin btn-admin--secundario">Editar</button>
                                    <button class="btn-admin btn-admin--peligro">Ocultar</button>
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
