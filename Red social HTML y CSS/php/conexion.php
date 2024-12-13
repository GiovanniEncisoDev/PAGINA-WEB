<?php 
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$BD = "redsocial";

// Establecer la conexión
$conexion = mysqli_connect($servidor, $usuario, $contraseña, $BD);

if (!$conexion) {
  echo "Fallo la conexión <br>";
  die("Connection failed: " . mysqli_connect_error());
} else {
  echo "Conexión exitosa";
}
?>
