<?php
require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion();
verificarRol(['Administrador', 'Técnico']);

ob_start();

$equipo = $_GET['equipo'] ?? 'camara'; // Valor por defecto

?>

<h2 class="mb-4">Registrar cámara</h2>

<form action="guardar.php" method="post" enctype="multipart/form-data" class="p-4" style="max-width: 950px; margin: auto;">
  <div class="row g-4">

    <!-- Equipo y Fecha -->
    <div class="col-md-4">
      <label class="form-label">Equipo</label>
      <input type="text" name= "equipo" placeholder="Escribe el tipo de dispositivo" class="form-control" required>
    </div>


    <div class="col-md-3">
      <label class="form-label">Fecha de instalación</label>
      <input type="date" name="fecha" class="form-control" required>
    </div>

    <!-- Modelo y Estado -->
    <div class="col-md-3">
      <label class="form-label">Modelo</label>
      <input type="text" name="modelo" placeholder="Escribe el modelo" class="form-control" required>
    </div>

    <div class="col-md-3">
      <label class="form-label">Estado del equipo</label>
      <select name="estado" class="form-select" required>
        <option value="">Selecciona</option>
        <option value="Activo">Activo</option>
        <option value="En mantenimiento">En mantenimiento</option>
        <option value="Desactivado">Desactivado</option>
      </select>
    </div>

    <!-- Sucursal y Observaciones -->
    <div class="col-md-6">
      <label class="form-label">Ubicación del equipo (Sucursal)</label>
      <input type="text" name="sucursal" placeholder="Escribe el lugar de la instalación" class="form-control" required>
    </div>

    <div class="col-md-5">
      <label class="form-label">Observaciones</label>
      <input type="text" name="observaciones" placeholder="Escribe alguna observación" class="form-control">
    </div>

    <!-- Serie y MAC -->
    <div class="col-md-3">
      <label class="form-label">Número de serie</label>
      <input type="text" name="serie" placeholder="Escribe el número de serie" class="form-control">
    </div>

    <div class="col-md-3">
      <label class="form-label">Dirección MAC</label>
      <input type="text" name="mac" placeholder="00:11:22:33:44:55" class="form-control">
    </div>

    <div class="col-md-3">
      <label class="form-label">No. de Servidor</label>
      <input type="text" name="servidor" placeholder= "Escribe el numero de servidor" class="form-control" value="<?= htmlspecialchars($device['servidor'] ?? '') ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">VMS</label>
      <input type="text" name="vms" placeholder= "Escribe el vms" class="form-control" value="<?= htmlspecialchars($device['servidor'] ?? '') ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Switch</label>
      <input type="text" name="switch" placeholder= "Escribe el switch" class="form-control" value="<?= htmlspecialchars($device['switch'] ?? '') ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Puerto</label>
      <input type="text" name="puerto" placeholder= "Escribe el número de puerto del switch" class="form-control" value="<?= htmlspecialchars($device['puerto'] ?? '') ?>">
    </div>

    <!-- Área de la tienda -->
    <div class="col-md-4">
      <label class="form-label">Área de la tienda</label>
      <input type="text" name="area" placeholder= "Escribe el area de la tienda" class="form-control" value="<?= htmlspecialchars($device['puerto'] ?? '') ?>">
    </div>

    <!-- Imagen principal -->
    <div class="col-md-6">
      <label class="form-label">Imagen del dispositivo</label>
      <input type="file" name="imagen" accept="image/*" class="form-control" required>
    </div>

    <!-- Imagen secundaria -->
    <div class="col-md-12">
      <label class="form-label">Imagen adicional o evidencia</label>
      <div class="border border-2 rounded p-4 text-center" style="background-color: #f5f1f1; border-color: #b69df0;">
        <i class="fas fa-image fa-2x mb-2 text-muted"></i>
        <input type="file" name="imagen2" accept="image/*,application/image" class="form-control mt-2" required>
      </div>
    </div>

    <!-- Botón -->
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-secondary px-5 py-2 rounded-pill shadow">
        <i class="fas fa-qrcode me-2"></i> Guardar y generar QR
      </button>
    </div>
  </div>
</form>


<?php
$content = ob_get_clean();
$pageTitle = "Registrar dispositivo";
$pageHeader = "Registro de dispositivo";
$activePage = "registro";

include __DIR__ . '/../../layout.php';
?>