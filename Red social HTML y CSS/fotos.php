<?php 
include("php/conexion.php");
include("php/validarSesion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fotos</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <header>
    <div id="logo">
      <img src="img/logo.jpg" alt="Logo de DuckSocial">
    </div>
    <nav class="menu">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="miPerfil.php">Mi Perfil</a></li>
        <li><a href="amigos.php">Mis Amigos</a></li>
        <li><a href="fotos.php">Mis Fotos</a></li>
        <li><a href="buscar.html">Buscar Amigos</a></li>
        <li><a href="php/CerrarSesion.php">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>
  
  <main>
    <section id="perfil">
      <img src="<?php echo htmlspecialchars($_SESSION['fotoPerfil']); ?>" alt="Foto de perfil de <?php echo htmlspecialchars($_SESSION['nombre']); ?>">
      <h1><?php echo htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellidos']); ?></h1>
      <form action="php/CambiarFoto.php" method="POST" enctype="multipart/form-data">
        <label for="archivo">Cambiar Foto de Perfil:</label>
        <input name="archivo" id="archivo" type="file" accept=".jpg, .jpeg, .png" required>
        <button type="submit" name="subir">Subir</button>
      </form>
    </section>

    <section id="recuadros">
      <h2>Mis Fotos</h2>
      <form action="php/SubirFoto.php" method="POST" enctype="multipart/form-data">
        <label for="archivo-galeria">Añadir imagen:</label>
        <input name="archivo" id="archivo-galeria" type="file" accept=".jpg, .jpeg, .png" required>
        <button type="submit" name="subir">Subir</button>
      </form>

      <div class="galeria">
        <?php 
        // Consulta para obtener las fotos del usuario
        $consulta = "SELECT * FROM fotos WHERE Nickname = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("s", $_SESSION['nickname']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Mostrar cada foto
        while ($fila = $result->fetch_assoc()) {
        ?>
          <section class="recuadro">
            <img src="<?php echo htmlspecialchars($fila['NombreFoto']); ?>" height="200" alt="Foto de <?php echo htmlspecialchars($_SESSION['nickname']); ?>">
          </section>
        <?php 
        }
        $stmt->close();
        ?>
      </div>
    </section>
  </main>
  <footer>
    <p>Copyright &copy; 2024, DuckSocial</p>
  </footer>
</body>
</html>
