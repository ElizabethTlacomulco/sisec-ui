<?php

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion();
verificarRol(['Administrador', 'Técnico', 'Invitado']);

include __DIR__ . '/../../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido o no especificado.');
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM dispositivos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$device = $result->fetch_assoc();

if (!$device) {
    die('Dispositivo no encontrado.');
}

ob_start();
?>

<h2>Ficha técnica</h2>

<div class="row">
  <div class="col-md-4 text-center">
    <img src="/sisec-ui/public/uploads/<?= htmlspecialchars($device['imagen']) ?>" 
         alt="Imagen del dispositivo" 
         class="img-fluid rounded shadow-sm" 
         style="max-height: 300px; object-fit: scale-down;">
  </div>

  <div class="col-md-8">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr><th>Equipo</th><td><?= htmlspecialchars($device['equipo']) ?></td></tr>
        <tr><th>Modelo</th><td><?= htmlspecialchars($device['modelo']) ?></td></tr>
        <tr><th>Serie</th><td><?= htmlspecialchars($device['serie']) ?></td></tr>
        <tr><th>Dirección MAC</th><td><?= htmlspecialchars($device['mac']) ?></td></tr>
        <tr><th>Ubicación del equipo</th><td><?= htmlspecialchars($device['sucursal']) ?></td></tr>
        <tr><th>Área de la tienda</th><td><?= htmlspecialchars($device['area']) ?></td></tr>
        <tr><th>Estado del equipo</th><td><?= htmlspecialchars($device['estado']) ?></td></tr>
        <tr><th>Fecha de instalación</th><td><?= htmlspecialchars($device['fecha']) ?></td></tr>
        <tr><th>Observaciones</th><td><?= nl2br(htmlspecialchars($device['observaciones'])) ?></td></tr>
        <tr><th>Imagen adjunta</th><td><a href="/sisec-ui/public/uploads/<?= htmlspecialchars($device['imagen2']) ?>" target="_blank">Ver imagen</a></td></tr>
        <tr><th>Código QR</th><td><img src="/sisec-ui/public/qrcodes/<?= htmlspecialchars($device['qr']) ?>" width="150" alt="Código QR"></td></tr>
      </tbody>
    </table>
    <a href="listar.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Volver al listado</a>
  </div>
</div>

<?php
$content = ob_get_clean();
$pageTitle = "Ficha dispositivo #$id";
$pageHeader = "Dispositivo #$id";
$activePage = "";

include __DIR__ . '/../../layout.php';

