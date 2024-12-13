<?php 
include("php/conexion.php");
include("php/validarSesion.php");
$nicknameA= $_GET['nickname'];
include("php/datosAmigos.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Red Social DuckSocial</title>
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
        <li><a href="miPerfil.html">Mi Perfil</a></li>
        <li><a href="amigos.html">Mis Amigos</a></li>
        <li><a href="fotos.html">Mis Fotos</a></li>
        <li><a href="buscar.html">Buscar Amigos</a></li>
      </ul>
    </nav>
  </header>

  <section id="perfil">
    <img src="<?php echo "$fotoPerfilA"?>" />
    <h1><?php echo "$nombreA $apellidosA"?></h1>
    <p><?php echo "$descripcionA"?></p>
  </section>

  <section id="amigos">
    <h2>Mis Amigos</h2>
    <?php 
    $consulta ="SELECT * FROM persona P WHERE P.Nickname in (SELECT A.Nickname FROM amistad A WHERE A.Nickname1='$nicknameA) Limit 3";
    $datos=mysqli_query($conexion, $consulta);
    while ($fila=mysqli_fetch_array($datos)){ 
    ?>
    <article class="recuadro">
      <img src="<?php echo $fila['FotoPerfil']?>" height="150" >
      <h3><?php echo $fila['Nombre'] . "" .$fila['Apellidos']?></h3>
      <p class="parrafo">
        <?php echo $fila['Descripcion']?>
      </p>
      <a href="<?php echo "perfil.php?nickname=".$fila['Nickname']?>" class="boton">Ver Perfil</a><br><br>
    </article>
  </section>
  <?php 
    }
  ?>

  <section id="fotos">
    <h2>Mis Fotos</h2>
    <?php 
    $consulta ="SELECT * FROM fotos F WHERE F.Nickname='$nicknameA'"
    $datos=mysqli_query($conexion, $consulta);
    while($fila=mysqli_fetch_array($datos)){
    ?>
    <article class="recuadro">
      <img src="<?php echo $fila['NombreFoto']?>" height="200" width="280">
    </article>
  </section>
  <?php 
    }
  ?>

  <footer>
    <p>Copyright &copy; 2024, DuckSocial</p>
  </footer>
</body>
</html>
