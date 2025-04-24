<?php
$host     = getenv('DB_HOST');
$port     = getenv('DB_PORT');
$dbname   = getenv('DB_NAME');
$user     = getenv('DB_USER');
$password = getenv('DB_PASS');
  // La contraseña de la base de datos

// Crear conexión
$conexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conexion) {
    echo "Error de conexión.";
} else {
    echo "¡Conexión exitosa!";
}
?>
