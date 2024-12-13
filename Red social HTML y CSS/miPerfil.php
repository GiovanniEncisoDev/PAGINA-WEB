<?php 
include("php/conexion.php");
include("php/validarSesion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mi Perfil</title>
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
        <li><a href="amigos.html">Mis Amigos</a></li>
        <li><a href="fotos.html">Mis Fotos</a></li>
        <li><a href="buscar.html">Buscar Amigos</a></li>
        <li><a href="php/CerrarSesion.php">Cerrar sesión</a></li>
      </ul>
    </nav>
  </header>

  <section id="perfil">
    <img src="<?php echo "$_SESSION['fotoPerfil']" ?>" >
    <h1><?php echo "$_SESSION['nombre'] $_SESSION['apellidos']" ?></h1>
    <p><?php echo "$_SESSION['descripcion']" ?></p>
  </section>

  <section id="amigos">
    <h2>Mis Amigos</h2>
    
    <?php
    $consulta = "SELECT * FROM persona WHERE Nickname IN (SELECT Nickname FROM amistad WHERE Nickname1 = ?) LIMIT 3";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($fila = $result->fetch_assoc()) {
    ?>
      <article class="recuadro">
        <img src="<?php echo htmlspecialchars($fila['FotoPerfil']); ?>" height="150" alt="Foto de Amigo">
        <h2><?php echo htmlspecialchars($fila['Nombre'] . " " . $fila['Apellidos']); ?></h2>
        <p class="parrafo"><?php echo htmlspecialchars($fila['Descripcion']); ?></p>
        <a href="perfil.php?nickname=<?php echo urlencode($fila['Nickname']); ?>" class="boton">Ver Perfil</a>
      </article>
    <?php 
    }
    $stmt->close();
    ?>
  </section>

  <section id="recuadros">
    <h2>Mis Fotos</h2>
    <?php
    $consulta = "SELECT * FROM fotos WHERE Nickname = ? LIMIT 3";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($fila = $result->fetch_assoc()) {
    ?>
      <article class="recuadro">
        <img src="<?php echo htmlspecialchars($fila['NombreFoto']); ?>" height="200" width="280" alt="Foto">
      </article>
    <?php 
    }
    $stmt->close();
    ?>
  </section>

  <footer>
    <p>Copyright &copy; 2024, DuckSocial</p>
  </footer>
</body>
</html>
 