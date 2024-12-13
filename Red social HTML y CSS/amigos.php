<?php 
include("php/conexion.php");
include("php/validarSesion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Amigos</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <header>
    <div id="logo">
      <img src="img/logo.jpg" alt="logo">
    </div>
    <nav class="menu">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="miPerfil.php">Mi Perfil</a></li>
        <li><a href="amigos.php">Mis Amigos</a></li>
        <li><a href="fotos.html">Mis Fotos</a></li>
        <li><a href="buscar.html">Buscar Amigos</a></li>
        <li><a href="php/CerrarSesion.php">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="amigos">
      <h2>Mis Amigos</h2>
      <?php
      // Consulta para obtener los amigos del usuario
      $consulta = "SELECT * FROM persona WHERE Nickname IN (SELECT Nickname FROM amistad WHERE Nickname1 = ?)";
      $stmt = $conexion->prepare($consulta);
      $stmt->bind_param("s", $nickname);
      $stmt->execute();
      $result = $stmt->get_result();

      // Mostrar los resultados
      while ($fila = $result->fetch_assoc()) {
      ?>
        <article class="recuadro">
          <img src="<?php echo htmlspecialchars($fila['FotoPerfil']); ?>" height="150" alt="Foto de perfil">
          <h2><?php echo htmlspecialchars($fila['Nombre'] . " " . $fila['Apellidos']); ?></h2>
          <a href="perfil.php?nickname=<?php echo urlencode($fila['Nickname']); ?>" class="boton">Ver Perfil</a>
        </article>
      <?php 
      }
      $stmt->close();
      ?>
    </section>
  </main>

  <footer>
    <p>Copyright &copy; 2024, DuckSocial</p>
  </footer>
</body>
</html>
