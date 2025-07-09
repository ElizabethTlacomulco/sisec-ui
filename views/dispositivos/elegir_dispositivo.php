<?php
require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion();
verificarRol(['Administrador', 'Técnico']);
?>

<?php
$pageTitle = "Registrar dispositivo";
$pageHeader = "Selecciona el Equipo de dispositivo";
$activePage = "registrar-dispositivo";
ob_start();
?>


<h2 class="mb-4">Selecciona el dispositivo que vas a registrar</h2>

<br>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <form action="redirigir_registro.php" method="get">
        <div class="mb-3">
          <label for="Equipo" class="form-label">Equipo de dispositivo</label>
          <select name="Equipo" id="Equipo" class="form-select" required>
            <option value="">Selecciona una opción</option>
            <option value="camara">Cámara</option>
            <option value="switch">Switch</option>
            <option value="servidor">Servidor</option>
            <option value="vms">VMS</option>
            <option value="conmutador">Conmutador</option>
            <option value="rack">Rack</option>
            <option value="sensor">Sensor de movimiento</option>
            <option value="humo">Detector de humo</option>
            <!-- Agrega más si necesitas -->
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Continuar</button>
      </form>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
