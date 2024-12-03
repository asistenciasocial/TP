<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Persona</title>
    <link rel="stylesheet" href="inicio/inicio.css">
</head>
<body>

    <div class="container">
        <h1>Formulario de Persona</h1>
        <form action="insertar.php" method="POST" enctype="multipart/form-data">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="clave">Clave</label>
            <input type="password" id="clave" name="clave" required>

            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar</button>
        </form>

        <!-- Botón para ir a la página de login de administrador -->
       
       <div>
       ㅤㅤㅤㅤ
       </div>
        <div class="login-button-container">
            <a href="login.php">
                <button type="button">Iniciar sesión como Administrador</button>
            </a>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>

</body>
</html>
