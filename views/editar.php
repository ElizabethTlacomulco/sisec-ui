<?php
include '../includes/db.php';

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
    <label class="form-label">Tipo</label>
    <select type="tipo" name="tipo" class="form-select" required>
      <option value="Camara" <?= $device['tipo'] == 'Camara' ? 'selected' : '' ?>>Camara</option>
      <option value="Alarma" <?= $device['tipo'] == 'Alarma' ? 'selected' : '' ?>>Alarma</option>
      <option value="Sensor de humo" <?= $device['tipo'] == 'Sensor de humo' ? 'selected' : '' ?>>Sensor de humo</option>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Modelo</label>
    <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($device['modelo']) ?>" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Sucursal</label>
    <input type="text" name="sucursal" class="form-control" value="<?= htmlspecialchars($device['sucursal']) ?>" required>
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
    <img src="../public/uploads/<?= htmlspecialchars($device['imagen']) ?>" width="200" alt="Imagen"><br>
    <label class="form-label mt-2">Cambiar imagen</label>
    <input type="file" name="imagen" class="form-control" accept="image/*">
  </div>

  <div class="col-md-6">
    <label class="form-label">Imagen actual:</label><br>
    <img src="../public/uploads/<?= htmlspecialchars($device['imagen2']) ?>" width="200" alt="Imagen"><br>
    <label class="form-label mt-2">Cambiar imagen</label>
    <input type="file" name="imagen2" class="form-control" accept="image2/*">
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

include __DIR__ . '/../layout.php';
