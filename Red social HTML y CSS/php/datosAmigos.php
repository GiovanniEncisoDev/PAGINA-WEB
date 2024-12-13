<?php 
include("php/conexion.php");
include("php/validarSesion.php");

// Validación de parámetros
if (!isset($nicknameA) || empty($nicknameA)) {
    header('Location: miPerfil.php');
    exit;
}

// Evitar acceso al perfil propio
if ($nickname === $nicknameA) {
    header('Location: miPerfil.php');
    exit;
}

// Consulta segura con prepared statements
$consulta = "SELECT Nombre, Apellidos, Edad, Descripcion, FotoPerfil FROM persona WHERE Nickname = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("s", $nicknameA);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nombreA = $usuario['Nombre'];
    $apellidosA = $usuario['Apellidos'];
    $edadA = $usuario['Edad'];
    $descripcionA = $usuario['Descripcion'];
    $fotoPerfilA = $usuario['FotoPerfil'];
} else {
    // Redirigir si no se encuentra el usuario
    header('Location: error.php?msg=UsuarioNoEncontrado');
    exit;
}

$stmt->close();
?>
