<?php
// session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum Admin | Configuración</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php require 'layout/sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h1>Configuración del Sistema</h1>
            </header>

            <section class="admin-grid" style="grid-template-columns: 1fr; max-width: 800px;">
                <div class="admin-card">
                    <h2 style="font-family: var(--fuente-serif); color: var(--color-dorado); margin-bottom: 20px;">Personalización de Marca</h2>
                    
                    <form action="../../backend/api.php" method="POST" class="admin-form">
                        <div class="form-group">
                            <label for="site_name">Nombre del Restaurante</label>
                            <input type="text" id="site_name" name="site_name" value="Aurum Restaurante">
                        </div>
                        
                        <div class="form-group">
                            <label for="primary_color">Color Principal</label>
                            <input type="color" id="primary_color" name="primary_color" value="#D32F2F" style="height: 50px; padding: 5px;">
                            <small style="color: var(--color-gris); display: block; margin-top: 5px;">Este color afectará a todos los botones y acentos de la página principal configurados con data-theme-color="primary".</small>
                        </div>

                        <div class="form-group">
                            <label for="whatsapp_number">Número de WhatsApp (Reservas)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" value="5215512345678">
                        </div>

                        <button type="submit" class="btn-admin btn-admin--primario" style="margin-top: 20px; font-size: var(--fs-sm); padding: 12px 24px;">Guardar Cambios</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
