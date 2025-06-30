<?php
$pageTitle = "Usuarios";
$pageHeader = "Gestión de usuarios";
$activePage = "usuarios";

include __DIR__ . '/../../includes/conexion.php';
ob_start();

// Obtener lista de usuarios
$usuarios = $conexion->query("SELECT id, nombre, rol FROM usuarios");
?>

<h2 class="mb-4">Usuarios registrados</h2>

<div class="mb-3 text-end">
  <a href="?view=usuarios_registrar" class="btn btn-success">
    <i class="fas fa-user-plus me-1"></i> Nuevo usuario
  </a>
</div>

<div class="table-responsive shadow-sm">
  <table class="table table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th style="width: 50px;"><i class="fas fa-user"></i></th>
        <th>Nombre</th>
        <th>Rol</th>
        <th style="width: 150px;" class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($u = $usuarios->fetch_assoc()): ?>
        <tr>
          <td class="text-center">
            <i class="fas fa-user-circle fa-2x text-secondary"></i>
          </td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['rol']) ?></td>
          <td class="text-center">
            <a href="?view=usuarios_editar&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning me-1">
              <i class="fas fa-edit"></i>
            </a>
            <a href="controllers/UserController.php?accion=eliminar&id=<?= $u['id'] ?>" 
               onclick="return confirm('¿Eliminar este usuario?')" 
               class="btn btn-sm btn-danger">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
?>
