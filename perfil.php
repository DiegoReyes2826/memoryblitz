<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: iniciarSesion.php");
  exit();
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Memory Blitz - Perfil</title>
  <link rel="stylesheet" href="css/stylePerfil.css" />
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
  <div class="perfil-container">
    <h1 class="bienvenida">🎉 ¡Bienvenido, <?php echo $nombre . ' ' . $apellido; ?>! 🎉</h1>
    <p class="descripcion-juego">
      ¡Prepárate para poner a prueba tu memoria como nunca antes!<br>
      En <strong>Memory Blitz</strong>, cada nivel es un reto lleno de luces, sonidos y adrenalina pura.<br>
      Memoriza las secuencias, supera tus límites y escala en el ranking global.<br>
      ¿Estás listo para entrar en el juego y convertirte en una leyenda del pixel?
    </p>
    <div class="botones-container">
      <a href="#"><button class="btn-azul">🏆 Ver puntuaciones globales</button></a>
      <a href="juegoUsuariosRegistrados.php"><button class="btn-verde">🕹️ Ir al juego</button></a>
      <a href="CerrarSesion.php"><button class="btn-rojo">🚪 Cerrar sesión</button></a>
    </div>
  </div>
</body>

</html>