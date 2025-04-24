<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="css/styleIniciarS.css" />
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>

  <h1 class="titulo-principal">Inicia sesión</h1>

  <div class="form-container">
    <!-- Ahora el formulario envía los datos a login.php -->
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email"> 📧 Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
      </div>

      <div class="form-group">
        <label for="contraseña">🔑 Contraseña</label>
        <input type="password" id="contraseña" name="contraseña" placeholder="********" required>
      </div>

      <button type="submit" name="btningresar">✅ Iniciar sesión</button>
    </form>
    <a href="index.php"><button class="boton-secundario"> ❌ Volver</button></a>
  </div>

</body>
</html>
