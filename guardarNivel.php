<?php
session_start();
include("modelo/conexion.php");  // $conexion es el recurso pg_connect()

header('Content-Type: application/json');

// 1) Comprobar sesión
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo json_encode(["success" => false, "message" => "No has iniciado sesión."]);
    exit();
}

// 2) Verificar método
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
    exit();
}

// 3) Recoger parámetros
$usuario_id = $_SESSION['id'];
$modo       = $_POST['modo']  ?? '';
$nivel      = $_POST['nivel'] ?? '';

// 4) Validar datos
if (!in_array($modo, ['facil', 'medio', 'dificil']) || !is_numeric($nivel)) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    exit();
}

// 5) Verificar si ya existe un progreso previo
$sqlSelect = "
    SELECT nivel 
    FROM progreso 
    WHERE usuario_id = $1 
      AND modo       = $2
";
$res = pg_query_params($conexion, $sqlSelect, [$usuario_id, $modo]);

if ($res === false) {
    echo json_encode(["success" => false, "message" => "Error en la consulta de progreso."]);
    exit();
}

if (pg_num_rows($res) > 0) {
    $row = pg_fetch_assoc($res);
    // 6) Si el nuevo nivel es mayor, actualizar
    if ((int)$nivel > (int)$row['nivel']) {
        $sqlUpdate = "
            UPDATE progreso 
            SET nivel = $1,
                fecha_guardado = NOW()
            WHERE usuario_id = $2
              AND modo       = $3
        ";
        $upd = pg_query_params($conexion, $sqlUpdate, [$nivel, $usuario_id, $modo]);

        if ($upd) {
            echo json_encode(["success" => true, "message" => "Nivel actualizado."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar nivel."]);
        }
    } else {
        // 7) Si no es mayor, no hacer nada
        echo json_encode(["success" => false, "message" => "Ya tienes un nivel igual o mayor registrado."]);
    }
} else {
    // 8) Si no existe, insertar un nuevo registro
    $sqlInsert = "
        INSERT INTO progreso (usuario_id, modo, nivel) 
        VALUES ($1, $2, $3)
    ";
    $ins = pg_query_params($conexion, $sqlInsert, [$usuario_id, $modo, $nivel]);

    if ($ins) {
        echo json_encode(["success" => true, "message" => "Nivel guardado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar nivel."]);
    }
}

// 9) Cerrar el script
exit();
?>
