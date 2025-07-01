<?php
$pageTitle = "Usuarios";
$pageHeader = "Gestión de usuarios";
$activePage = "usuarios";

include __DIR__ . '/../../includes/conexion.php';
ob_start();

// Obtener lista de usuarios con foto
$usuarios = $conexion->query("SELECT id, nombre, rol, foto FROM usuarios");
?>

<h2 class="mb-4">Usuarios registrados</h2>

<div class="mb-3 text-end">
  <a href="/sisec-ui/views/usuarios/registrar.php" class="btn btn-success">
    <i class="fas fa-user-plus me-1"></i> Nuevo usuario
  </a>
</div>

<div class="table-responsive shadow-sm">
  <table class="table table-hover align-middle">
    <thead class="table-primary">
      <tr>
        <th style="width: 60px;"><i class="fas fa-user"></i></th>
        <th>Nombre</th>
        <th>Rol</th>
        <th style="width: 150px;" class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($u = $usuarios->fetch_assoc()): ?>
        <?php
          $foto = $u['foto']
            ? "/sisec-ui/uploads/usuarios/" . $u['foto']
            : "https://i.pravatar.cc/40?u=" . $u['id'];
        ?>
        <tr>
          <td class="text-center">
            <img src="<?= $foto ?>" alt="Foto de usuario" class="rounded-circle" width="40" height="40">
          </td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['rol']) ?></td>
          <td class="text-center">
            <a href="editar.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning me-1">
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
