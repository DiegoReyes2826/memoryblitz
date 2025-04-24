<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crea tu cuenta...</title>
  <link rel="stylesheet" href="css/styleCrearCuenta.css" />
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>

  <h1 class="titulo-principal">¡Crea tu cuenta!</h1>

  <?php include "modelo/conexion.php"; ?>

  <div class="form-container">
    <form method="POST">
      <h3 class="form-title">👤 Registro de Jugador 👤</h3>
      <?php include "controlador/registro_persona.php"; ?>

      <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" placeholder="Ingresa tu nombre" required>
      </div>

      <div class="form-group">
        <label>Apellido</label>
        <input type="text" name="apellido" placeholder="Ingresa tu apellido" required>
      </div>

      <div class="form-group">
        <label>Correo electrónico</label>
        <input type="email" name="email" placeholder="ejemplo@correo.com" required>
      </div>

      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="contraseña" placeholder="********" required>
      </div>

      <div class="form-group">
        <label>Confirmar contraseña</label>
        <input type="password" name="confContraseña" placeholder="********" required>
      </div>

      <button type="submit" name="btnregistrar" value="ok">✅ Registrar</button>
      
    </form>
    <a href="iniciarSesion.html"><button>👤Iniciar sesion</button></a>
      <a href="index.html"><button class="boton-secundario"> ❌ Volver</button></a>
  </div>

</body>
</html>
