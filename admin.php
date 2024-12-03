<?php
session_start();
include('config.php');

// Verificar si el usuario es un administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php"); // Redirigir al login si no es admin
    exit();
}

// Obtener los registros de la base de datos
$sql = "SELECT * FROM persona";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }

        .action-buttons a {
            margin: 0 10px;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .action-buttons a:hover {
            background-color: #218838;
        }

        .logout {
            display: block;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Panel de Administrador</h1>
        <table>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['apellido']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['fecha']}</td>
                            <td>{$row['usuario']}</td>
                            <td>{$row['email']}</td>
                            <td class='action-buttons'>
                                <a href='editar.php?id={$row['id']}'>Editar</a>
                                <a href='eliminar.php?id={$row['id']}'>Eliminar</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay registros.</td></tr>";
            }
            ?>

        </table>
        <div class="back-link">
    <form action="index.php" method="get">
        <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px;">Volver a la página de inicio</button>
    </form>
</div>

        <a href="logout.php" class="logout">Cerrar sesión</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
