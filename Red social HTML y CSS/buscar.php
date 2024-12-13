<?php 
include("php/conexion.php");
include("php/validarSesion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Buscar Amigos</title>
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
        <li><a href="index.php">Inicio</a></li>
        <li><a href="miPerfil.php">Mi Perfil</a></li>
        <li><a href="amigos.php">Mis Amigos</a></li>
        <li><a href="fotos.php">Mis Fotos</a></li>
        <li><a href="buscar.php">Buscar Amigos</a></li>
        <li><a href="php/CerrarSesion.php">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section id="buscar-amigos">
      <h2>Encuentra nuevos amigos</h2>
      <?php 
      // Consulta segura con prepared statements
      $consulta = "SELECT * FROM persona P WHERE P.Nickname != ? AND P.Nickname NOT IN (SELECT A.Nickname2 FROM amistad A WHERE A.Nickname1 = ?)";
      $stmt = $conexion->prepare($consulta);
      $stmt->bind_param("ss", $_SESSION['nickname'], $_SESSION['nickname']);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($fila = $result->fetch_assoc()) {
      ?>
        <section class="recuadro">
          <img src="<?php echo htmlspecialchars($fila['FotoPerfil']); ?>" height="150" alt="Foto de perfil de <?php echo htmlspecialchars($fila['Nombre'] . ' ' . $fila['Apellidos']); ?>">
          <h2><?php echo htmlspecialchars($fila['Nombre'] . ' ' . $fila['Apellidos']); ?></h2>
          <a href="perfil.php?nickname=<?php echo urlencode($fila['Nickname']); ?>" class="boton">Ver perfil</a>
          <a href="php/agregarAmigo.php?nickname=<?php echo urlencode($fila['Nickname']); ?>" class="boton">Agregar</a><br><br>
        </section>
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
