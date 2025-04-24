<?php
$host = "dpg-d054j1vgi27c73calun0-a";  // Host que te dio Render
$port = "5432";  // Puerto estándar de PostgreSQL
$dbname = "memoryblitz";  // El nombre de la base de datos
$user = "memoryblitz_user";  // El usuario de la base de datos
$password = "CRHFInu37nCMKGYa7ZIBXy0w6nNfKCnn";  // La contraseña de la base de datos

// Crear conexión
$conexion = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conexion) {
    echo "Error de conexión.";
} else {
    echo "¡Conexión exitosa!";
}
?>
