<?php
if (!empty($_POST["btnregistrar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["email"]) && !empty($_POST["contraseña"]) && !empty($_POST["confContraseña"])) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];
        $confContraseña = $_POST["confContraseña"];

        if ($contraseña !== $confContraseña) {
            echo '<div class="alert alert-danger"> Las contraseñas no coinciden.</div>';
        } else {
            $contraseña_segura = password_hash($contraseña, PASSWORD_DEFAULT);

            $sql = $conexion->query("INSERT INTO persona(nombre, apellido, email, contraseña) VALUES ('$nombre', '$apellido', '$email', '$contraseña_segura')");

            if ($sql == true) {
                echo '<div class="alert alert-success"> Persona registrada correctamente.</div>';
            } else {
                echo '<div class="alert alert-danger"> Error al registrar la persona.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning"> Ingresa todos los campos solicitados.</div>';
    }
}
?>
