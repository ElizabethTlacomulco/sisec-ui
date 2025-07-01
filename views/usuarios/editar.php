<?php
$pageTitle = "Editar usuario";
$pageHeader = "Editar usuario";
$activePage = "usuarios";

include __DIR__ . '/../../includes/conexion.php';

if (!isset($_GET['id'])) {
  echo "<p>⚠️ ID de usuario no proporcionado.</p>";
  exit;
}

$id = intval($_GET['id']);
$consulta = $conexion->query("SELECT * FROM usuarios WHERE id = $id");

if ($consulta->num_rows === 0) {
  echo "<p>❌ Usuario no encontrado.</p>";
  exit;
}

$usuario = $consulta->fetch_assoc();
ob_start();
?>

<h2 class="mb-4">Editar usuario</h2>

<form action="controllers/UserController.php" method="POST" class="card p-4 shadow-sm" style="max-width: 500px;">
  <input type="hidden" name="accion" value="actualizar">
  <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo</label>
    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
  </div>

  <div class="mb-3">
    <label for="rol" class="form-label">Rol</label>
    <select class="form-select" id="rol" name="rol" required>
      <option value="">Seleccione un rol</option>
      <option value="Administrador" <?= $usuario['rol'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
      <option value="Técnico" <?= $usuario['rol'] === 'Técnico' ? 'selected' : '' ?>>Técnico</option>
      <option value="Invitado" <?= $usuario['rol'] === 'Invitado' ? 'selected' : '' ?>>Invitado</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-1"></i> Actualizar
  </button>
  <a href="?view=usuarios" class="btn btn-secondary ms-2">Cancelar</a>
</form>

<?php
$content = ob_get_clean();

include __DIR__ . '/../../layout.php';

?>
