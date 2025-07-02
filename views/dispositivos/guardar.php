<?php

include __DIR__ . '/../../includes/db.php';
include __DIR__ . '/../../vendor/phpqrcode/qrlib.php'; // Asegúrate que este archivo existe

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo         = $_POST['tipo'];
    $modelo       = $_POST['modelo'];
    $sucursal     = $_POST['sucursal'];
    $estado       = $_POST['estado'];
    $fecha        = $_POST['fecha'];
    $observaciones= $_POST['observaciones'];

    $imagen   = $_FILES['imagen']['name'];
    $imagen2  = $_FILES['imagen2']['name'];

    // Guardar imágenes en /public/uploads/
    move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen);
    move_uploaded_file($_FILES['imagen2']['tmp_name'], __DIR__ . '/../../public/uploads/' . $imagen2);

    // Guardar datos del dispositivo
    $stmt = $conn->prepare("INSERT INTO dispositivos (tipo, modelo, sucursal, estado, fecha, observaciones, imagen, imagen2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $tipo, $modelo, $sucursal, $estado, $fecha, $observaciones, $imagen, $imagen2);
    $stmt->execute();

    $id = $stmt->insert_id;

    // Generar QR
    $qr_filename = 'qr_' . $id . '.png';
    $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;
    $qr_url  = 'http://localhost/sisec-ui/views/dispositivos/device.php?id=' . $id;

    QRcode::png($qr_url, $qr_path, QR_ECLEVEL_H, 10);

    // Guardar nombre del archivo QR en la base de datos
    $conn->query("UPDATE dispositivos SET qr = '$qr_filename' WHERE id = $id");

    header('Location: device.php?id=' . $id);
    exit;
}

