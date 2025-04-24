<?php
session_start();
include("modelo/conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo json_encode(["success" => false, "message" => "No has iniciado sesión."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['id'];
    $modo = $_POST['modo'] ?? '';
    $nivel = $_POST['nivel'] ?? '';

    if (!in_array($modo, ['facil', 'medio', 'dificil']) || !is_numeric($nivel)) {
        echo json_encode(["success" => false, "message" => "Datos inválidos."]);
        exit();
    }

    // Verificar si ya existe un nivel guardado mayor o igual
    $stmt = $conexion->prepare("SELECT nivel FROM progreso WHERE usuario_id = ? AND modo = ?");
    $stmt->bind_param("is", $usuario_id, $modo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $registro = $resultado->fetch_assoc();
        if ($nivel > $registro['nivel']) {
            // Actualizar solo si el nuevo nivel es mayor
            $update = $conexion->prepare("UPDATE progreso SET nivel = ?, fecha_guardado = NOW() WHERE usuario_id = ? AND modo = ?");
            $update->bind_param("iis", $nivel, $usuario_id, $modo);
            $update->execute();
            echo json_encode(["success" => true, "message" => "Nivel actualizado."]);
        } else {
            echo json_encode(["success" => false, "message" => "Ya tienes un nivel igual o mayor registrado."]);
        }
    } else {
        // Insertar si no hay registro previo
        $insert = $conexion->prepare("INSERT INTO progreso (usuario_id, modo, nivel) VALUES (?, ?, ?)");
        $insert->bind_param("isi", $usuario_id, $modo, $nivel);
        $insert->execute();
        echo json_encode(["success" => true, "message" => "Nivel guardado exitosamente."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
