<?php
<<<<<<< Updated upstream
=======

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Mantenimientos']);

// session_start(); 

>>>>>>> Stashed changes
ob_start(); // Inicia el buffer
?>

<h2 class="mb-4">Registrar nuevo dispositivo</h2>

<form action="guardar.php" method="post" enctype="multipart/form-data" class="p-4" style="max-width: 950px; margin: auto;">
  <div class="row g-4">

    <!-- Tipo y Fecha -->
    <div class="col-md-3">
      <label class="form-label">Tipo de dispositivo</label>
      <select name="tipo" class="form-select" required>
        <option value="">Selecciona</option>
        <option value="Cámara">Cámara</option>
        <option value="Sensor">Sensor</option>
        <option value="Detector de humo">Detector de humo</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Fecha de instalación</label>
      <input type="date" name="fecha" class="form-control" required>
    </div>

    <!-- Modelo y Estado -->
    <div class="col-md-6">
      <label class="form-label">Modelo</label>
      <input type="text" name="modelo" placeholder="Escribe el modelo" class="form-control" required>
    </div>

    <div class="col-md-3">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select" required>
        <option value="">Selecciona</option>
        <option value="Activo">Activo</option>
        <option value="En mantenimiento">En mantenimiento</option>
        <option value="Desactivado">Desactivado</option>
      </select>
    </div>

    <!-- Sucursal y Observaciones -->
    <div class="col-md-6">
      <label class="form-label">Sucursal</label>
      <input type="text" name="sucursal" placeholder="Escribe el lugar de la instalación" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Observaciones</label>
      <input type="text" name="observaciones" placeholder="Escribe alguna observación" class="form-control">
    </div>

    <!-- Imagen principal -->
    <div class="col-md-4">
      <label class="form-label">Sube la imagen del dispositivo</label>
        <input type="file" name="imagen" accept="image/*" class="form-control" required>
    </div>

    <!-- Archivo adjunto -->
    <div class="col-md-12">
      <label class="form-label">Archivos adjuntos</label>
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
// Variables para el layout
$content = ob_get_clean();
$pageTitle = "Registrar dispositivo";
$pageHeader = "Registro de dispositivo";
$activePage = "registro";

include __DIR__ . '/../../layout.php';
?>
