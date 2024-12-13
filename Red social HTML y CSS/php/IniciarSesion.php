<?php
include("Conexion.php");

session_start();
$_SESSION['login'] = false;

$nickname = $_POST["nickname"];
$password = $_POST["constraseña"]; // Nota: Parece que "constraseña" es un error tipográfico

// Consulta SQL
$consulta = "SELECT * FROM persona WHERE Nickname = '$nickname'";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si se encontró el usuario
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_array($resultado);

    // Verificar contraseña
    if (password_verify($password, $usuario['Password'])) {
        $_SESSION['login'] = true;
        $_SESSION['nickname'] = $usuario['Nickname'];
        $_SESSION['nombre'] = $usuario['Nombre'];
        $_SESSION['apellidos'] = $usuario['Apellidos'];
        $_SESSION['edad'] = $usuario['Edad'];
        $_SESSION['descripcion'] = $usuario['Descripcion'];
        $_SESSION['fotoPerfil'] = $usuario['FotoPerfil'];

        header('Location: ../miPerfil.php');
        exit();
    } else {
        echo "Contraseña incorrecta.";
        echo "<br> <a href='../index.html'>Inténtalo de nuevo</a>";
    }
} else {
    echo "El usuario no existe.";
    echo "<br> <a href='../index.html'>Inténtalo de nuevo</a>";
}

mysqli_close($conexion);
?>
