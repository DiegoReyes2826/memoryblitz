<?php
$conexion = pg_connect("host=dpg-d054j1vgi27c73calun0-a port=5432 dbname=memoryblitz user=memoryblitz_user password=CRHFInu37nCMKGYa7ZIBXy0w6nNfKCnn sslmode=require");

if (!$conexion) {
    echo "Error de conexión.";
} else {
    echo "¡Conexión exitosa!";
}
?>
