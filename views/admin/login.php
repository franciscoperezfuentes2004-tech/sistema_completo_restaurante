<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurum | Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-fondo);
        }
        .login-box {
            background: var(--color-fondo-tarjeta);
            padding: 40px;
            border-radius: var(--radio-md);
            border: 1px solid var(--color-borde);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box h1 {
            font-family: var(--fuente-serif);
            color: var(--color-dorado);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-gris-claro);
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            background: var(--color-fondo-claro);
            border: 1px solid var(--color-gris-oscuro);
            color: white;
            border-radius: var(--radio-sm);
        }
        .btn-login {
            width: 100%;
            padding: 15px;
            background: var(--color-dorado);
            color: var(--color-fondo);
            border: none;
            border-radius: var(--radio-sm);
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1 data-theme-color="primary">Aurum Admin</h1>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-login" data-theme-bg="primary">Ingresar al Panel</button>
            </form>
        </div>
    </div>
</body>
</html>
