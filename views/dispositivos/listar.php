<?php
include __DIR__ . '/../../includes/db.php';


// Obtener todos los dispositivos
$result = $conn->query("SELECT * FROM dispositivos ORDER BY id ASC");

ob_start();
?>

<h2>Listado de dispositivos</h2>

<table class="table table-striped table-bordered text-center align-middle">
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
        <a href="device.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secundary">
          <i class="fas fa-eye"></i> Ver
        </a>
        <a href="editar.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secundary">
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
