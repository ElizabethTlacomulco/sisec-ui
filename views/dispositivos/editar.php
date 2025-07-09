<?php

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Técnico']);

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

<h2>Editar dispositivo</h2>

<form action="actualizar.php" method="post" enctype="multipart/form-data" class="row g-3">
  <input type="hidden" name="id" value="<?= $device['id'] ?>">

  <div class="col-md-6">
    <label class="form-label">Equipo</label>
    <select name="equipo" class="form-select" required>
      <option value="camara" <?= $device['equipo'] == 'camara' ? 'selected' : '' ?>>Camara</option>
      <option value="Sensores de movimiento" <?= $device['equipo'] == 'Sensores de movimiento' ? 'selected' : '' ?>>Sensores de movimiento</option>
      <option value="Detectores de humo" <?= $device['equipo'] == 'Detectores de humo' ? 'selected' : '' ?>>Detectores de humo</option>
      <option value="NVR's" <?= $device['equipo'] == "NVR's" ? 'selected' : '' ?>>NVR's</option>
      <option value="DVR's" <?= $device['equipo'] == "DVR's" ? 'selected' : '' ?>>DVR's</option>
      <option value="VMS's" <?= $device['equipo'] == "VMS's" ? 'selected' : '' ?>>VMS's</option>
      <option value="Switch" <?= $device['equipo'] == "Switch" ? 'selected' : '' ?>>Switch</option>
      <option value="Conmutador" <?= $device['equipo'] == "Conmutador" ? 'selected' : '' ?>>Conmutador</option>
      <option value="Rack" <?= $device['equipo'] == "Rack" ? 'selected' : '' ?>>Rack</option>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Modelo</label>
    <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($device['modelo']) ?>" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Serie</label>
    <input type="text" name="serie" class="form-control" value="<?= htmlspecialchars($device['serie']) ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Dirección MAC</label>
    <input type="text" name="mac" class="form-control" value="<?= htmlspecialchars($device['mac']) ?>">
  </div>

  <div class="col-md-6">
  <label class="form-label">No. de Servidor</label>
  <input type="text" name="servidor" class="form-control" value="<?= htmlspecialchars($device['servidor'] ?? '') ?>">
</div>

  <div class="col-md-6">
    <label class="form-label">VMS</label>
    <select name="vms" id="vms" class="form-select">
      <option value="">Selecciona</option>
      <option value="Avigilon" <?= ($device['vms'] ?? '') == 'Avigilon' ? 'selected' : '' ?>>Avigilon</option>
      <option value="Milestone" <?= ($device['vms'] ?? '') == 'Milestone' ? 'selected' : '' ?>>Milestone</option>
      <option value="Otro" <?= ($device['vms'] ?? '') == 'Otro' ? 'selected' : '' ?>>Otro</option>
    </select>
  </div>

  <div class="col-md-6" id="vmsOtroDiv" style="display: none;">
    <label class="form-label">Especifica VMS</label>
    <input type="text" name="vms_otro" class="form-control" value="<?= htmlspecialchars($device['vms_otro'] ?? '') ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Switch</label>
    <input type="text" name="switch" class="form-control" value="<?= htmlspecialchars($device['switch'] ?? '') ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Puerto</label>
    <input type="text" name="puerto" class="form-control" value="<?= htmlspecialchars($device['puerto'] ?? '') ?>">
  </div>


  <div class="col-md-6">
    <label class="form-label">Sucursal</label>
    <input type="text" name="sucursal" class="form-control" value="<?= htmlspecialchars($device['sucursal']) ?>" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Área</label>
    <input type="text" name="area" class="form-control" value="<?= htmlspecialchars($device['area']) ?>">
  </div>

  <div class="col-md-6">
    <label class="form-label">Estado</label>
    <select name="estado" class="form-select" required>
      <option value="Activo" <?= $device['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
      <option value="En mantenimiento" <?= $device['estado'] == 'En mantenimiento' ? 'selected' : '' ?>>En mantenimiento</option>
      <option value="Desactivado" <?= $device['estado'] == 'Desactivado' ? 'selected' : '' ?>>Desactivado</option>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Fecha</label>
    <input type="date" name="fecha" class="form-control" value="<?= htmlspecialchars($device['fecha']) ?>" required>
  </div>

  <div class="col-12">
    <label class="form-label">Observaciones</label>
    <textarea name="observaciones" class="form-control" rows="3"><?= htmlspecialchars($device['observaciones']) ?></textarea>
  </div>

  <div class="col-md-6">
    <label class="form-label">Imagen actual:</label><br>
    <?php if (!empty($device['imagen'])): ?>
      <img src="/sisec-ui/public/uploads/<?= htmlspecialchars($device['imagen']) ?>" width="200" alt="Imagen">
    <?php endif; ?>
    <br>
    <label class="form-label mt-2">Cambiar imagen</label>
    <input type="file" name="imagen" class="form-control" accept="image/*">
  </div>

  <div class="col-md-6">
    <label class="form-label">Imagen actual 2:</label><br>
    <?php if (!empty($device['imagen2'])): ?>
      <img src="/sisec-ui/public/uploads/<?= htmlspecialchars($device['imagen2']) ?>" width="200" alt="Imagen 2">
    <?php endif; ?>
    <br>
    <label class="form-label mt-2">Cambiar imagen 2</label>
    <input type="file" name="imagen2" class="form-control" accept="image/*">
  </div>

  <div class="col-md-6">
    <label class="form-label">Código QR:</label><br>
    <?php if (!empty($device['qr'])): ?>
      <img src="/sisec-ui/public/qrcodes/<?= htmlspecialchars($device['qr']) ?>" width="150" alt="Código QR">
    <?php endif; ?>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
    <a href="device.php?id=<?= $id ?>" class="btn btn-secondary">Cancelar</a>
  </div>
</form>

<?php
$content = ob_get_clean();
$pageTitle = "Editar dispositivo #$id";
$pageHeader = "Editar dispositivo";
$activePage = "";

include __DIR__ . '/../../layout.php';
