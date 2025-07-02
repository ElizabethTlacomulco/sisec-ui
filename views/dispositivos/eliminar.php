<?php
include __DIR__ . '/../../includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Primero busca si existe el dispositivo
    $check = $conn->prepare("SELECT id FROM dispositivos WHERE id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Si existe, elimínalo
        $stmt = $conn->prepare("DELETE FROM dispositivos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

header("Location: listar.php");
exit;
