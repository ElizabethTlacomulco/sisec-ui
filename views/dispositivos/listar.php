<?php 

require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // 1️⃣ Verifica si hay sesión iniciada
verificarRol(['Administrador', 'Técnico', 'Invitado']);

include __DIR__ . '/../../includes/db.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Buscar con filtro
if ($search !== '') {
    $stmt = $conn->prepare("
        SELECT * FROM dispositivos 
        WHERE 
            equipo LIKE ? OR 
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
    <input type="text" name="search" class="form-control" placeholder="Buscar por ID, equipo, modelo, fecha..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
  </form>

  <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
    <a href="registro.php" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar nuevo dispositivo</a>
  <?php endif; ?>
</div>

<table class="table-responsive table table-striped table-bordered text-center align-middle">
  <thead class="table-primary">
    <tr>
      <th>Folio</th>
      <th>Equipo</th>
      <th>Fecha de instalación</th>
      <th>Modelo</th>
      <th>Estado del equipo</th>
      <th>Ubicación del equipo (Sucursal)</th>
      <th>Observaciones</th>
      <th>Serie</th>
      <th>Dirección MAC</th>
      <th>VMS</th>
      <th>Servidor</th>
      <th>Switch</th>
      <th>Puerto</th>
      <th>Área</th>
      <th>Imagen</th>
      <th>Código QR</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($device = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($device['id']) ?></td>
      <td><?= htmlspecialchars($device['equipo']) ?></td>
      <td><?= htmlspecialchars($device['fecha']) ?></td>
      <td><?= htmlspecialchars($device['modelo']) ?></td>
      <td><?= htmlspecialchars($device['estado']) ?></td>
      <td><?= htmlspecialchars($device['sucursal']) ?></td>
      <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($device['observaciones']) ?></td>
      <td><?= htmlspecialchars($device['serie']) ?></td>
      <td><?= htmlspecialchars($device['mac']) ?></td>
      <td><?= htmlspecialchars($device['vms']) ?></td>
      <td><?= htmlspecialchars($device['servidor']) ?></td>
      <td><?= htmlspecialchars($device['switch']) ?></td>
      <td><?= htmlspecialchars($device['puerto']) ?></td>
      <td><?= htmlspecialchars($device['area']) ?></td>
      <td>
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
        <a href="device.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-primary">
          <i class="fas fa-eye"></i> Ver
        </a>

        <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
          <a href="editar.php?id=<?= $device['id'] ?>" class="btn btn-sm btn-secondary">
            <i class="fa-regular fa-pen-to-square"></i> Editar
          </a>
        <?php endif; ?>

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

<?php
$content = ob_get_clean();
$pageTitle = "Listado de dispositivos";
$pageHeader = "Dispositivos";
$activePage = "dispositivos";

include __DIR__ . '/../../layout.php';
?>