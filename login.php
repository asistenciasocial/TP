<?php
session_start();

$tiempo_expiracion_cookie = 30 * 24 * 60 * 60;
$tiempo_expiracion_sesion = 30 * 60; 


if (isset($_SESSION['admin']) || (isset($_COOKIE['usuario_admin']) && $_COOKIE['usuario_admin'] === 'admin')) {
    header('Location: admin.php'); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    if ($usuario === 'admin' && $clave === 'admin123') {
        $_SESSION['admin'] = true; 
        $_SESSION['ultimo_acceso'] = time(); 

    
        if (isset($_POST['recordarme'])) {
            setcookie('usuario_admin', 'admin', time() + $tiempo_expiracion_cookie, '/'); 
        }

        header('Location: admin.php');
        exit();
    } else {
        echo "<div class='error-message'>Usuario o clave incorrectos.</div>";
    }
}


if (isset($_SESSION['ultimo_acceso']) && (time() - $_SESSION['ultimo_acceso']) > $tiempo_expiracion_sesion) {
    session_destroy(); 
    setcookie('usuario_admin', '', time() - 3600, '/'); 
    header("Location: login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .remember-me {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login de Administrador</h1>
        <form method="POST" action="">
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" required><br><br>
            <label for="clave">Contraseña:</label><br>
            <input type="password" name="clave" required><br><br>

            <div class="remember-me">
                <input type="checkbox" name="recordarme" id="recordarme">
                <label for="recordarme">Recordarme</label>
            </div>

            <input type="submit" value="Ingresar">
        </form>
    </div>
</body>
</html>
