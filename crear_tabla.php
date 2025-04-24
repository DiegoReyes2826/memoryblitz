<?php
$conexion = pg_connect("host=dpg-d054j1vgi27c73calun0-a port=5432 dbname=memoryblitz user=memoryblitz_user password=CRHFInu37nCMKGYa7ZIBXy0w6nNfKCnn sslmode=require");

if (!$conexion) {
    die("❌ Error de conexión.");
}

$sql = "CREATE TABLE persona (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    contraseña TEXT
)";

$result = pg_query($conexion, $sql);

if ($result) {
    echo "✅ Tabla 'persona' creada con éxito.";
} else {
    echo "❌ Error al crear la tabla: " . pg_last_error($conexion);
}
?>
