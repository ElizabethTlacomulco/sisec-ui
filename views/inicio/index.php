<?php

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Técnico']);

include __DIR__ . '/../../includes/db.php';


ob_start();

// Consultas reales a la base de datos
$camaras = $conn->query("SELECT COUNT(*) AS total FROM dispositivos WHERE tipo = 'Camara'")->fetch_assoc()['total'];
$sensores = $conn->query("SELECT COUNT(*) AS total FROM dispositivos WHERE tipo = 'Sensor'")->fetch_assoc()['total'];
$usuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'] ?? 0;
$mantenimiento = $conn->query("SELECT COUNT(*) AS total FROM dispositivos WHERE estado = 'En mantenimiento'")->fetch_assoc()['total'];

// Dispositivos por tipo
$tipos_result = $conn->query("SELECT tipo, COUNT(*) as cantidad FROM dispositivos GROUP BY tipo");
$tipos_dispositivos = [];
while ($row = $tipos_result->fetch_assoc()) {
    $tipos_dispositivos[$row['tipo']] = (int)$row['cantidad'];
}

// Actividad de los últimos 7 días (simulado por ahora)
$actividad = [27, 17, 16, 28, 13, 4, 0];
?>

<h2 class="mb-4">Panel de control</h2>

<!-- KPIs -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fas fa-video fa-2x text-primary mb-2"></i>
        <h5 class="card-title mb-0"><?= $camaras ?></h5>
        <small class="text-muted">Cámaras registradas</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fas fa-wifi fa-2x text-info mb-2"></i>
        <h5 class="card-title mb-0"><?= $sensores ?></h5>
        <small class="text-muted">Sensores activos</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fas fa-user fa-2x text-success mb-2"></i>
        <h5 class="card-title mb-0"><?= $usuarios ?></h5>
        <small class="text-muted">Usuarios registrados</small>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <i class="fas fa-tools fa-2x text-danger mb-2"></i>
        <h5 class="card-title mb-0"><?= $mantenimiento ?></h5>
        <small class="text-muted">Cámaras en mantenimiento</small>
      </div>
    </div>
  </div>
</div>

<!-- Gráficas -->
<div class="row g-4 mb-4">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="card-title mb-3">Dispositivos por tipo</h6>
        <canvas id="chartDispositivos" height="200"></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h6 class="card-title mb-3">Actividad de los últimos 7 días</h6>
        <canvas id="chartActividad" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Botones rápidos -->
<div class="d-flex justify-content-center gap-3">
  <div class="col-md-3">
    <a href="/sisec-ui/views/dispositivos/registro.php" class="btn btn-outline-primary w-100 py-3 rounded shadow-sm">
      <i class="fas fa-qrcode fa-lg me-2"></i> Registro nuevo dispositivo
    </a>
  </div>
  <div class="col-md-3">
    <a href="/sisec-ui/views/usuarios/registrar.php" class="btn btn-outline-success w-100 py-3 rounded shadow-sm">
      <i class="fas fa-user-plus fa-lg me-2"></i> Registro rápido de usuario
    </a>
  </div>
</div>


<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx1 = document.getElementById('chartDispositivos').getContext('2d');
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($tipos_dispositivos)) ?>,
      datasets: [{
        label: 'Cantidad',
        data: <?= json_encode(array_values($tipos_dispositivos)) ?>,
        backgroundColor: '#4aa3df'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });

  const ctx2 = document.getElementById('chartActividad').getContext('2d');
  new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
      datasets: [{
        label: 'Registros',
        data: <?= json_encode($actividad) ?>,
        fill: true,
        backgroundColor: 'rgba(0,123,255,0.2)',
        borderColor: '#007bff'
      }]
    },
    options: {
      responsive: true
    }
  });
</script>

<?php
$content = ob_get_clean();


include __DIR__ . '/../../layout.php';
