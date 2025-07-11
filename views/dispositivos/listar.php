<<<<<<< Updated upstream
<?php
=======
<?php 

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Mantenimientos', 'Invitado']);

// session_start(); //
>>>>>>> Stashed changes
include __DIR__ . '/../../includes/db.php';


// Obtener todos los dispositivos
$result = $conn->query("SELECT * FROM dispositivos ORDER BY id ASC");

ob_start();
?>

<h2>Listado de dispositivos</h2>

<<<<<<< Updated upstream
<table class="table table-striped table-bordered text-center align-middle">
=======
<!-- Buscador y botón alineados -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
  <form method="GET" style="display: flex; gap: 10px;">
    <input type="text" name="search" class="form-control" placeholder="Buscar por ID, equipo, modelo, fecha..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
  </form>

  <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Mantenimientos'])): ?>
    <a href="registro.php" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar nuevo dispositivo</a>
  <?php endif; ?>
</div>

<table class="table-responsive table table-striped table-bordered text-center align-middle">
>>>>>>> Stashed changes
  <thead class="table-primary">
    <tr>
      <th>ID</th>
      <th>Tipo</th>
      <th>Modelo</th>
      <th>Sucursal</th>
      <th>Estado</th>
      <th>Fecha</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($device = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($device['id']) ?></td>
      <td><?= htmlspecialchars($device['tipo']) ?></td>
      <td><?= htmlspecialchars($device['modelo']) ?></td>
      <td><?= htmlspecialchars($device['sucursal']) ?></td>
      <td><?= htmlspecialchars($device['estado']) ?></td>
      <td><?= htmlspecialchars($device['fecha']) ?></td>
      
      <td>
<<<<<<< Updated upstream
        <a href="device.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secundary">
          <i class="fas fa-eye"></i> Ver
        </a>
        <a href="editar.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secundary">
=======
        <?php if (!empty($device['imagen'])): ?>
          <img src="/sisec-ui/public/uploads/<?= htmlspecialchars($device['imagen']) ?>" alt="Imagen" style="max-height:50px; object-fit: contain;">
        <?php endif; ?>
      </td>
      <td>
        <?php if (!empty($device['qr'])): ?>
          <img src="/sisec-ui/public/qrcodes/<?= htmlspecialchars($device['qr']) ?>" alt="QR" width="50">
        <?php endif; ?>
      </td>
      <td>
      <!-- Botón ver: siempre visible -->
      <a href="device.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-primary">
        <i class="fas fa-eye"></i> Ver
      </a>

      <!-- Botón editar: solo Administrador y Mantenimientos -->
      <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Mantenimientos'])): ?>
        <a href="editar.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secondary">
>>>>>>> Stashed changes
          <i class="fa-regular fa-pen-to-square"></i> Editar
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<a href="registro.php" class="btn btn-success mt-3"><i class="fas fa-plus"></i> Registrar nuevo dispositivo</a>

<?php
$content = ob_get_clean();
$pageTitle = "Listado de dispositivos";
$pageHeader = "Dispositivos";
$activePage = "dispositivos";

include __DIR__ . '/../../layout.php';
