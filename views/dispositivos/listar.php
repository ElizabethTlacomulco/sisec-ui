<?php 

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Técnico', 'Invitado']);

// session_start(); //
include __DIR__ . '/../../includes/db.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Buscar con filtro
if ($search !== '') {
    $stmt = $conn->prepare("
        SELECT * FROM dispositivos 
        WHERE 
            tipo LIKE ? OR 
            modelo LIKE ? OR 
            sucursal LIKE ? OR 
            estado LIKE ? OR 
            fecha = ? OR 
            id = ?
        ORDER BY id ASC
    ");

    $likeSearch = "%$search%";
    $stmt->bind_param("sssssi", $likeSearch, $likeSearch, $likeSearch, $likeSearch, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM dispositivos ORDER BY id ASC");
}

ob_start();
?>

<h2>Listado de dispositivos</h2>

<!-- Buscador y botón alineados -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
  <form method="GET" style="display: flex; gap: 10px;">
    <input type="text" name="search" class="form-control" placeholder="Buscar por ID, tipo, modelo, fecha..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
  </form>

  <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
    <a href="registro.php" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar nuevo dispositivo</a>
  <?php endif; ?>
</div>

<table class="table-responsive table table-striped table-bordered text-center align-middle">
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
      <!-- Botón ver: siempre visible -->
      <a href="device.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-primary">
        <i class="fas fa-eye"></i> Ver
      </a>

      <!-- Botón editar: solo Administrador y técnico -->
      <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
        <a href="editar.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secondary">
          <i class="fa-regular fa-pen-to-square"></i> Editar
        </a>
      <?php endif; ?>

      <!-- Botón eliminar: solo Administrador -->
      <?php if ($_SESSION['usuario_rol'] === 'Administrador'): ?>
        <button 
            class="btn btn-sm btn-danger" 
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal"
            data-id="<?= $device['id'] ?>"
        >
          <i class="fas fa-trash-alt"></i> Eliminar
        </button>
      <?php endif; ?>

      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php if ($_SESSION['usuario_rol'] === 'Administrador'): ?>
  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          ¿Estás segura(o) de que deseas eliminar este dispositivo?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="deleteLink" class="btn btn-danger">Eliminar</a>
        </div>

      </div>
    </div>
  </div>

  <script>
    var deleteModal = document.getElementById('confirmDeleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var deviceId = button.getAttribute('data-id');

      var deleteLink = deleteModal.querySelector('#deleteLink');
      deleteLink.href = 'eliminar.php?id=' + deviceId;
    });
  </script>
<?php endif; ?>


<script>
  var deleteModal = document.getElementById('confirmDeleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var deviceId = button.getAttribute('data-id');

    var deleteLink = deleteModal.querySelector('#deleteLink');
    deleteLink.href = 'eliminar.php?id=' + deviceId;
  });
</script>

<?php
$content = ob_get_clean();
$pageTitle = "Listado de dispositivos";
$pageHeader = "Dispositivos";
$activePage = "dispositivos";

include __DIR__ . '/../../layout.php';
?>
