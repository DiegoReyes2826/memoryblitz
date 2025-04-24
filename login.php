<?php
session_start();
include("modelo/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["contraseña"])) {
        $email = $_POST["email"];
        $password = $_POST["contraseña"];

        // Consulta con PostgreSQL
        $sql = "SELECT * FROM persona WHERE email = $1";
        $stmt = pg_query_params($conexion, $sql, array($email));

        if ($stmt) {
            $usuario = pg_fetch_assoc($stmt);

            if ($usuario) {
                if (password_verify($password, $usuario['contraseña'])) {
                    // Guardar sesión
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['apellido'] = $usuario['apellido'];
                    $_SESSION['email'] = $usuario['email'];

                    header("Location: perfil.php");
                    exit();
                } else {
                    mostrarError("❌ Contraseña incorrecta.");
                }
            } else {
                mostrarError("❌ El correo no está registrado.");
            }
        } else {
            mostrarError("⚠️ Error en la consulta.");
        }
    } else {
        mostrarError("⚠️ Por favor, ingresa tu correo y contraseña.");
    }
} else {
    header("Location: iniciarSesion.php");
    exit();
}

function mostrarError($mensaje) {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Iniciar sesión - Error</title>
        <link href='https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap' rel='stylesheet'>
        <style>
            body {
                background: radial-gradient(circle at center, #1a1a1a, #000);
                font-family: 'Press Start 2P', cursive;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                height: 100vh;
                text-align: center;
            }

            .mensaje-error {
                background-color: rgba(255, 0, 0, 0.1);
                border: 2px solid #ff4c4c;
                color: #ff4c4c;
                padding: 20px;
                border-radius: 12px;
                max-width: 400px;
                box-shadow: 0 0 15px #ff4c4c;
            }

            .mensaje-error a {
                display: inline-block;
                margin-top: 15px;
                color: #00ffcc;
                text-decoration: none;
            }

            button {
                margin-top: 10px;
                padding: 10px 20px;
                font-size: 12px;
                border: none;
                border-radius: 12px;
                background-color: #ff4c4c;
                color: #fff;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            button:hover {
                background-color: #e60000;
            }
        </style>
    </head>
    <body>
        <div class='mensaje-error'>
            $mensaje<br>
            <a href='iniciarSesion.php'><button>🔁 Volver al formulario</button></a>
        </div>
    </body>
    </html>";
    exit();
}
?>
