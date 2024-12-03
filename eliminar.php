<?php

include('config.php');


session_start();
if (!isset($_SESSION['admin'])) {
    die("No tienes permiso para acceder a esta página.");
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM persona WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }
}

?>

<a href="admin.php">Volver al Panel de Administrador</a>

<?php

$conn->close();
?>
