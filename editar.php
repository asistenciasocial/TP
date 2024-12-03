<?php

include('config.php');

session_start();
if (!isset($_SESSION['admin'])) {
    die("No tienes permiso para acceder a esta página.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    
    $sql = "SELECT * FROM persona WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("No se encontró el registro.");
    }
} else {
    die("ID no válido.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $email = $_POST['email'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['tmp_name'];
        $foto_blob = addslashes(file_get_contents($foto));
    } else {
        $foto_blob = $row['foto']; 
    }

   
    $sql_update = "UPDATE persona SET apellido = ?, nombre = ?, fecha = ?, foto = ?, usuario = ?, clave = ?, email = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssi", $apellido, $nombre, $fecha, $foto_blob, $usuario, $clave, $email, $id);
    
    if ($stmt_update->execute()) {
        echo "Registro actualizado exitosamente.";
    } else {
        echo "Error al actualizar el registro: " . $stmt_update->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="editar.php?id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data">
        <label>Apellido:</label><br>
        <input type="text" name="apellido" value="<?php echo $row['apellido']; ?>" required><br><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required><br><br>

        <label>Fecha de Nacimiento:</label><br>
        <input type="date" name="fecha" value="<?php echo $row['fecha']; ?>" required><br><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" value="<?php echo $row['usuario']; ?>" required><br><br>

        <label>Clave:</label><br>
        <input type="password" name="clave" value="<?php echo $row['clave']; ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>

        <label>Foto (opcional):</label><br>
        <input type="file" name="foto"><br><br>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>

<?php

$conn->close();
?>
