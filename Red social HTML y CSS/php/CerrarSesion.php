<?php
session_start();

// Vaciar todas las variables de sesión
$_SESSION = [];

// Eliminar la cookie de la sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 4200,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio
header('Location: ../index.html');
exit(); // Asegura que el script no continúe ejecutándose
?>
