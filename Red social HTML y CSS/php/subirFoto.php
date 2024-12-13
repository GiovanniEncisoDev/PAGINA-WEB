<?php
include("Conexion.php");
include("validarSesion.php");

// Validar que se haya enviado un archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] != UPLOAD_ERR_OK) {
    echo "Error: No se envió ningún archivo o hubo un problema con la subida.";
    echo "<a href='../fotos.php'> Volver.</a>";
    exit;
}

// Validar el tipo de archivo (solo imágenes permitidas)
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['archivo']['type'], $allowedTypes)) {
    echo "Error: Solo se permiten archivos de tipo JPG, PNG o GIF.";
    echo "<a href='../fotos.php'> Volver.</a>";
    exit;
}

// Obtener un nuevo ID de foto automáticamente
$consulta = "SELECT COALESCE(MAX(idFotos), 0) + 1 AS newId FROM fotos";
$resultado = $conexion->query($consulta);
if (!$resultado) {
    echo "Error al obtener el ID de la foto: " . $conexion->error;
    echo "<a href='../fotos.php'> Volver.</a>";
    exit;
}
$idFoto = $resultado->fetch_assoc()['newId'];

// Preparar la ruta de destino
$directorioUsuario = "../img/$nickname";
if (!is_dir($directorioUsuario)) {
    mkdir($directorioUsuario, 0755, true); // Crear directorio si no existe
}
$ubicacion = "$directorioUsuario/$idFoto.jpg";

// Mover el archivo subido a su ubicación final
if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $ubicacion)) {
    echo "Error: No se pudo mover el archivo subido.";
    echo "<a href='../fotos.php'> Volver.</a>";
    exit;
}

// Guardar información de la foto en la base de datos
$ubicacionRelativa = "img/$nickname/$idFoto.jpg"; // Ruta relativa
$stmt = $conexion->prepare("INSERT INTO fotos (idFotos, Nickname, Ubicacion) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $idFoto, $nickname, $ubicacionRelativa);

if ($stmt->execute()) {
    echo "Tu imagen ha sido guardada exitosamente.";
    header('Location: ../fotos.php');
    exit;
} else {
    echo "Error al guardar la imagen en la base de datos: " . $conexion->error;
    echo "<a href='../fotos.php'> Volver.</a>";
    exit;
}

// Cerrar recursos
$stmt->close();
$conexion->close();
?>
