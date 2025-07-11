<?php

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Técnico']);

include __DIR__ . '/../../includes/db.php';
include __DIR__ . '/../../vendor/phpqrcode/qrlib.php'; // Asegúrate que existe

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipo         = $_POST['equipo'];
    $fecha         = $_POST['fecha'];
    $modelo         = $_POST['modelo'];
    $estado         = $_POST['estado'];
    $sucursal         = $_POST['sucursal'];
    $observaciones  = $_POST['observaciones'];
    $serie          = $_POST['serie'];
    $mac            = $_POST['mac'];
    $vms            = $_POST['vms'];
    $servidor       = $_POST['servidor'];
    $switch           = $_POST['switch'];
    $puerto         = $_POST['puerto'];
    $area          = $_POST['area'];

    $imagen   = $_FILES['imagen']['name'];
    $imagen2  = $_FILES['imagen2']['name'];

    // Guardar imágenes en /public/uploads/
    move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen);
    move_uploaded_file($_FILES['imagen2']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen2);

    // Insertar dispositivo con nuevos campos
    $stmt = $conn->prepare("INSERT INTO dispositivos (equipo, fecha, modelo, estado, sucursal, observaciones, serie, mac, vms, servidor, switch, puerto, area, imagen, imagen2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssss", $equipo, $fecha, $modelo, $estado, $sucursal, $observaciones, $serie, $mac, $vms, $servidor, $switch, $puerto, $area, $imagen, $imagen2);
    $stmt->execute();

    $id = $stmt->insert_id;

    // Registrar notificación si no es admin
    if ($_SESSION['usuario_rol'] !== 'Administrador') {
        $mensaje = "El técnico " . $_SESSION['nombre'] . " registró un nuevo dispositivo.";
        $usuario_id = $_SESSION['usuario_id'];

        $stmtNotif = $conn->prepare("INSERT INTO notificaciones (usuario_id, mensaje, fecha, visto, dispositivo_id) VALUES (?, ?, NOW(), 0, ?)");
        $stmtNotif->bind_param("isi", $usuario_id, $mensaje, $id);
        $stmtNotif->execute();
        $stmtNotif->close();
    }

    // Generar QR
    $qr_filename = 'qr_' . $id . '.png';
    $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;
    $qr_url  = 'http://localhost/sisec-ui/views/dispositivos/device.php?id=' . $id;

    QRcode::png($qr_url, $qr_path, QR_ECLEVEL_H, 10);

    // Guardar QR en DB
    $conn->query("UPDATE dispositivos SET qr = '$qr_filename' WHERE id = $id");

    header('Location: device.php?id=' . $id);
    exit;
}
