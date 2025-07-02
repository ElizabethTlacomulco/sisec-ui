<?php

include __DIR__ . '/../../includes/db.php';
include __DIR__ . '/../../vendor/phpqrcode/qrlib.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo         = $_POST['tipo'];
    $modelo       = $_POST['modelo'];
    $sucursal     = $_POST['sucursal'];
    $estado       = $_POST['estado'];
    $fecha        = $_POST['fecha'];
    $observaciones= $_POST['observaciones'];

    $imagen   = $_FILES['imagen']['name'];
    $imagen2  = $_FILES['imagen2']['name'];

    move_uploaded_file($_FILES['imagen']['tmp_name'], '../public/uploads/' . $imagen);
    move_uploaded_file($_FILES['imagen2']['tmp_name'], '../public/uploads/' . $imagen2);

    $stmt = $conn->prepare("INSERT INTO dispositivos (tipo, modelo, sucursal, estado, fecha, observaciones, imagen, imagen2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $tipo, $modelo, $sucursal, $estado, $fecha, $observaciones, $imagen, $imagen2);
    $stmt->execute();

    $id = $stmt->insert_id;

    // Generar QR con URL del dispositivo
    $qr_path = 'sisec-ui/public/qrcodes/qr_' . $id . '.png';
    $qr_url  = 'http://localhost/sisec-ui/views/dispositivos/device.php?id=' . $id;
    QRcode::png($qr_url, $qr_path, QR_ECLEVEL_H, 10);

    $conn->query("UPDATE dispositivos SET qr = 'qr_$id.png' WHERE id = $id");

    header('Location: device.php?id=' . $id);
    exit;
}

