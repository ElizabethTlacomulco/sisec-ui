<?php

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion();
verificarRol(['Administrador', 'Técnico']);

include __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acceso no autorizado.');
}

$id            = (int)$_POST['id'];
$tipo          = $_POST['tipo'];
$modelo        = $_POST['modelo'];
$sucursal      = $_POST['sucursal'];
$estado        = $_POST['estado'];
$fecha         = $_POST['fecha'];
$observaciones = $_POST['observaciones'];

// Obtener datos actuales
$stmt = $conn->prepare("SELECT imagen, imagen2 FROM dispositivos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$actual = $result->fetch_assoc();
$stmt->close();

// Manejo de imagen
$imagen  = $actual['imagen'];
$imagen2 = $actual['imagen2'];

if (!empty($_FILES['imagen']['name'])) {
    $imagen = basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . "/../../public/uploads/" . $imagen);
}

if (!empty($_FILES['imagen2']['name'])) {
    $imagen2 = basename($_FILES['imagen2']['name']);
    move_uploaded_file($_FILES['imagen2']['tmp_name'], __DIR__ . "/../../public/uploads/" . $imagen2);
}

// Actualizar base de datos
$update = $conn->prepare("UPDATE dispositivos SET tipo=?, modelo=?, sucursal=?, estado=?, fecha=?, observaciones=?, imagen=?, imagen2=? WHERE id=?");
$update->bind_param("ssssssssi", $tipo, $modelo, $sucursal, $estado, $fecha, $observaciones, $imagen, $imagen2, $id);
$update->execute();
$update->close();


// ✅ REGISTRAR NOTIFICACIÓN si no es administrador
if ($_SESSION['usuario_rol'] !== 'Administrador') {
    $mensaje     = "El técnico " . $_SESSION['nombre'] . " modificó el dispositivo con ID #" . $id . ".";
    $usuario_id  = $_SESSION['usuario_id'];

    $stmtNotif = $conn->prepare("INSERT INTO notificaciones (usuario_id, mensaje, fecha, visto, dispositivo_id) VALUES (?, ?, NOW(), 0, ?)");
    $stmtNotif->bind_param("isi", $usuario_id, $mensaje, $id);
    $stmtNotif->execute();
    $stmtNotif->close();
}

// Redirigir a la vista del dispositivo
header("Location: device.php?id=$id");
exit;

