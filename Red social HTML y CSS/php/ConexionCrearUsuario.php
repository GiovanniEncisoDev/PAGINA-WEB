<?php
include("conexion.php");

$nickname = $_POST["nickname"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$edad = $_POST["edad"];
$descripcion = $_POST["descripcion"];
$email = $_POST["correo"];
$password = $_POST["constraseña"]; // Nota: Parece que "constraseña" es un error tipográfico

$passwordHash = password_hash($password, PASSWORD_BCRYPT);
$fotoPerfil = "img/$nickname/perfil.jpg";

// Verificar si el nickname ya existe
$consultaID = "SELECT Nickname FROM persona WHERE Nickname = '$nickname'";
$resultadoConsulta = mysqli_query($conexion, $consultaID);
$consultaID = mysqli_fetch_array($resultadoConsulta);

if (!$consultaID) {
    // Insertar los datos en la base de datos
    $sql = "INSERT INTO persona (Nickname, Nombre, Apellidos, Edad, Descripcion, FotoPerfil, Email, Password) 
            VALUES ('$nickname', '$nombre', '$apellidos', '$edad', '$descripcion', '$fotoPerfil', '$email', '$passwordHash')";
    
    if (mysqli_query($conexion, $sql)) {
        // Crear directorio y copiar imagen de perfil por defecto
        mkdir("../img/$nickname", 0755, true);
        copy("../img/default.jpg", "../img/$nickname/perfil.jpg");

        echo "Tu cuenta ha sido creada.";
        echo "<br> <a href='../index.html'>Iniciar Sesión</a>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
} else {
    echo "El nickname ya existe.";
    echo "<br> <a href='../index.html'>Inténtalo de nuevo</a>";
}
?>
