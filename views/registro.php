<?php
ob_start(); // Comienza a guardar el contenido en buffer
?>

<h2>Registrar nuevo dispositivo</h2>

<form action="guardar.php" method="post" enctype="multipart/form-data" class="row g-3">

  <div class="col-md-6">
    <label class="form-label">Tipo</label>
    <select type="tipo" name="tipo" class="form-select" required>
      <option value="">Selecciona</option>
      <option value="Camara">Camara</option>
      <option value="Sensor">Sensor</option>
      <option value="Detector de humo">Detector de humo</option>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Modelo</label>
    <input type="text" name="modelo" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Sucursal</label>
    <input type="text" name="sucursal" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Estado</label>
    <select type="tipo" name="estado" class="form-select" required>
      <option value="">Selecciona</option>
      <option value="Activo">Activo</option>
      <option value="En mantenimiento">En mantenimiento</option>
      <option value="Desactivado">Desactivado</option>
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Fecha</label>
    <input type="date" name="fecha" class="form-control" required>
  </div>

  <div class="col-12">
    <label class="form-label">Observaciones</label>
    <textarea name="observaciones" class="form-control" rows="3"></textarea>
  </div>

  <div class="col-md-6">
    <label class="form-label">Imagen</label>
    <input type="file" name="imagen" accept="image/*" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Imagen secundaria</label>
    <input type="file" name="imagen2" accept="image/*" class="form-control" required>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar dispositivo</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$pageTitle = "Registrar dispositivo";
$pageHeader = "Registro de dispositivo";
$activePage = "registro";

include '../includes/layout.php';
