<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración | Admin</title>
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
                <h1>Configuración</h1>
                <div class="admin-header__acciones"></div>
            </header>

            <div class="admin-card">
                <h2 style="color: var(--admin-accent-light); margin-bottom: 1.5rem; font-size: 1.25rem;">Personalización de Marca</h2>

                <form class="admin-form" action="../../backend/api.php" method="POST">
                    <div class="form-group">
                        <label for="nombre_restaurante">Nombre del Restaurante</label>
                        <input type="text" id="nombre_restaurante" name="nombre_restaurante" placeholder="Ej. La Casa del Chef" value="">
                    </div>

                    <div class="form-group">
                        <label for="color_principal">Color Principal</label>
                        <input type="color" id="color_principal" name="color_principal" value="#D32F2F">
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">Número de WhatsApp</label>
                        <input type="text" id="whatsapp" name="whatsapp" placeholder="Ej. +52 55 1234 5678" value="">
                    </div>

                    <div class="form-group" style="margin-top: 1rem;">
                        <button type="submit" class="btn-admin btn-admin--primario">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
