<?php
session_start();

session_unset();

session_destroy();

setcookie('usuario_admin', '', time() - 3600, '/'); // Elimina la cookie

header("Location: login.php");
exit();
?>
