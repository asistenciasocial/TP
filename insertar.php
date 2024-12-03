<?php
include('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $fecha = $_POST['fecha'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo electrónico no tiene un formato válido.");
    }

    if (strpos($email, '@gmail.com') === false) {
        die("El correo debe ser una cuenta de Gmail.");
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['tmp_name'];
        $nombre_foto = $_FILES['foto']['name'];
        
        $foto_tipo = mime_content_type($foto);
        if (!in_array($foto_tipo, ['image/jpeg', 'image/png', 'image/gif'])) {
            die("El archivo no es una imagen válida (solo JPG, PNG, o GIF).");
        }

        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            die("La imagen es demasiado grande. El tamaño máximo permitido es 2MB.");
        }

        $foto_blob = addslashes(file_get_contents($foto));
    } else {
        die("Error al cargar la foto.");
    }

    $stmt = $conn->prepare("INSERT INTO persona (apellido, nombre, fecha, foto, usuario, clave, email) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $apellido, $nombre, $fecha, $foto_blob, $usuario, $clave, $email);

    if ($stmt->execute()) {

        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registro Exitoso</title>
            <link rel='stylesheet' href='inicio/styless.css'> <!-- Ruta correcta si el CSS está en la carpeta 'inicio' -->
        </head>
        <body>
            <div class='success-message'>
                <h2>¡Registro Exitoso!</h2>
                <p>Tu cuenta se ha creado correctamente. Revisa tu correo electrónico para la confirmación.</p>
                <a href='index.php' class='back-button'>Volver al inicio</a>
            </div>
        </body>
        </html>";
        

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tu_correo@gmail.com';
            $mail->Password = 'tu_contraseña';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('tu_correo@gmail.com', 'Nombre del Remitente');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Registro';
            $mail->Body    = 'Hola ' . $nombre . ',<br><br>Gracias por registrarte. Tu cuenta ha sido creada exitosamente.';

            $mail->send();
            echo 'Correo de confirmación enviado.';
        } catch (Exception $e) {
            echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
