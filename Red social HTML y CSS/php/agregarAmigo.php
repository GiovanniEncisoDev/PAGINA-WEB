<?php 
include("php/conexion.php");
include("php/validarSesion.php");

// Validación de parámetros
if (!isset($_GET['nickname']) || empty($_GET['nickname'])) {
    echo "Error: Nickname no válido.";
    echo "<a href='../buscar.php'> Volver</a>";
    exit;
}

$nicknameA = $_GET['nickname'];

// Validar que no estás intentando agregarte como amigo
if ($nickname === $nicknameA) {
    echo "No puedes agregarte como amigo.";
    echo "<a href='../buscar.php'> Volver</a>";
    exit;
}

try {
    // Usar transacciones para garantizar la atomicidad
    $conexion->begin_transaction();

    // Inserción segura con prepared statements
    $stmt = $conexion->prepare("INSERT INTO amistad (Nickname1, Nickname2) VALUES (?, ?)");
    $stmt->bind_param("ss", $nickname, $nicknameA);

    if ($stmt->execute()) {
        // Insertar la relación inversa
        $stmt->bind_param("ss", $nicknameA, $nickname);
        if ($stmt->execute()) {
            $conexion->commit();
            echo "Ahora tienes un nuevo amigo.";
            header("Location: ../buscar.php");
            exit;
        } else {
            throw new Exception("Error al insertar la relación inversa.");
        }
    } else {
        throw new Exception("Error al insertar la relación de amistad.");
    }
} catch (Exception $e) {
    $conexion->rollback();
    echo "Se produjo un error: " . $e->getMessage();
    echo "<a href='../buscar.php'> Volver</a>";
}

// Cerrar recursos
$stmt->close();
$conexion->close();
?>
""