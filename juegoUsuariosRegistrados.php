<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$usuario    = $_SESSION['nombre']; // nombre del usuario
$idUsuario  = $_SESSION['id'];     // ID del usuario
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Memory Blitz</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
  <script>
    localStorage.clear();
  </script>

  <div class="container">

    <!-- 🏠 Pantalla Principal -->
    <div id="pantalla-principal">
      <h1 class="titulo">🎮 MEMORY BLITZ</h1>
      <p class="subtitulo">¿Hasta dónde llega tu memoria?</p>
      <div class="panel-botones">
        <button id="btn-ir-dificultad" class="boton-jugar">¡Jugar!</button>
        <button id="config-btn" class="boton-secundario">⚙ Configuración</button>
        <button id="ayuda-btn" class="boton-secundario">❓ Ayuda</button>
        <button class="boton-secundario" onclick="irAlInicio()">❌ Salir </button>
        <p id="mejor-nivel-principal" class="mejor-nivel">🏆 Mejor nivel alcanzado: 0</p>
        <p id="saludo-nombre" class="mejor-nivel"></p>
      </div>
    </div>
    <script>
      function irAlInicio() {
        window.location.href = "perfil.php";
      }
    </script>

    <!-- 🎚️ Pantalla de Selección de Dificultad -->
    <div id="pantalla-dificultad" style="display: none;">
      <h2 class="subtitulo">Selecciona la dificultad</h2>
      <div class="panel-botones">
        <button class="boton-jugar" onclick="seleccionarDificultad('facil')">🟢 Fácil</button>
        <button class="boton-jugar" onclick="seleccionarDificultad('medio')">🟡 Medio</button>
        <button class="boton-jugar" onclick="seleccionarDificultad('dificil')">🔴 Difícil</button>
        <button class="boton-secundario" onclick="volverAInicio()">⬅ Volver</button>
      </div>
    </div>

    <!-- 🕹️ Pantalla del Juego -->
    <div id="pantalla-juego" style="display: none;">
      <div id="game-board" class="tablero">
        <div class="color-btn" id="rojo"></div>
        <div class="color-btn" id="verde"></div>
        <div class="color-btn" id="azul"></div>
        <div class="color-btn" id="amarillo"></div>
      </div>
      <p id="estado-juego" class="estado">Selecciona una dificultad para comenzar</p>
      <p id="mejor-nivel" class="estado">🎯 Mejor nivel: 0</p>
      <button onclick="reiniciarJuego()" class="boton-secundario">🔁 Reiniciar</button>
    </div>


    <!-- ⚙️ Pantalla de Configuración -->
<div id="pantalla-configuracion" style="display: none;">
  <h2 class="subtitulo">Configuración</h2>
  <div class="panel-botones">
    <button id="toggle-sonido" class="boton-secundario">🔇 Desactivar sonido</button>
    <button id="reiniciar-record" class="boton-secundario">🧹 Reiniciar mejor puntaje</button>
    <button onclick="volverAInicio()" class="boton-secundario">⬅ Volver</button>
  </div>
</div>


<!-- ❓ Pantalla de Ayuda -->
<div id="pantalla-ayuda" style="display: none;">
  <h2 class="subtitulo">¿Cómo jugar?</h2>
  <div class="panel-ayuda">
    <p>🧠 Memoriza la secuencia de colores que se ilumina.</p>
    <p>👆 Repite la secuencia haciendo clic en los mismos colores en orden.</p>
    <p>🎯 Si aciertas, subes de nivel y la secuencia se hace más larga.</p>
    <p>💥 Si te equivocas, el juego se reinicia.</p>
    <p>🟢 <strong>Fácil:</strong> Empiezas con 2 y aumenta de 1 en 1.</p>
    <p>🟡 <strong>Medio:</strong> Empiezas con 3 y aumenta de 2 en 2.</p>
    <p>🔴 <strong>Difícil:</strong> Empiezas con 4 y aumenta de 3 en 3.</p>
    <p>🔇 Puedes silenciar sonidos y reiniciar tu mejor puntaje desde Configuración.</p>
    <button onclick="volverAInicio()" class="boton-secundario">⬅ Volver</button>
  </div>
</div>


<!-- 👤 Pantalla para ingresar nombre -->
<div id="pantalla-nombre">
  <h2 class="subtitulo">Ingresa tu nombre</h2>
  <input type="text" id="input-nombre" placeholder="Tu nombre" class="campo-nombre"/>
  <button class="boton-jugar" onclick="guardarNombre()">✅ Continuar</button>
  <button class="boton-secundario" onclick="irAlInicio()">❌ Salir </button>
</div>




    <footer>
      <p>Desarrollado por Brayan Pulido & Diego Reyes</p>
    </footer>
  </div>

  <script src="js/script.js"></script>
</body>
</html>
