<?php
// backend/auth.php integration can be added here later
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum | Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style.css">
    <style>
        body {
            background-color: var(--color-fondo);
            margin: 0;
            overflow: hidden; /* Prevent scroll on login */
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }
        .login-box {
            background: rgba(15, 15, 15, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 50px 40px;
            border-radius: var(--radio-lg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 2;
        }
        .login-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--color-dorado), transparent);
            opacity: 0.5;
        }
        .login-box h1 {
            font-family: var(--fuente-serif);
            font-size: 2.5rem;
            color: var(--color-blanco);
            margin-bottom: 5px;
            letter-spacing: 2px;
        }
        .login-subtitle {
            color: var(--color-gris-claro);
            font-family: var(--fuente-sans);
            font-size: var(--fs-sm);
            margin-bottom: 40px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-gris-claro);
            font-size: var(--fs-sm);
            letter-spacing: 1px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--color-gris-oscuro);
            color: white;
            border-radius: var(--radio-sm);
            font-family: var(--fuente-sans);
            transition: var(--transicion);
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--color-dorado);
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 2px rgba(211, 47, 47, 0.1);
        }
        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--color-dorado);
            color: var(--color-fondo);
            border: none;
            border-radius: var(--radio-sm);
            font-weight: 600;
            font-size: var(--fs-base);
            cursor: pointer;
            margin-top: 15px;
            transition: var(--transicion);
            font-family: var(--fuente-sans);
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px var(--color-dorado);
        }
    </style>
</head>
<body>
    <!-- Efecto de Fondo Animado (Mismo de la Landing Page) -->
    <div class="fondo-animado">
        <div class="orbe orbe-1" data-theme-bg="primary"></div>
        <div class="orbe orbe-2"></div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h1>AURUM</h1>
            <div class="login-subtitle" data-theme-color="primary">Portal de Administración</div>
            
            <form action="../../backend/auth.php" method="POST">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-login" data-theme-bg="primary">Acceder</button>
            </form>
        </div>
    </div>
</body>
</html>
