<?php
$pageTitle = "Registrar usuario";
$pageHeader = "Nuevo usuario";
$activePage = "usuarios";

ob_start();
?>

<h2 class="mb-4">Registrar nuevo usuario</h2>

<form action="controllers/UserController.php" method="POST" class="card p-4 shadow-sm" style="max-width: 500px;">
  <input type="hidden" name="accion" value="crear">

  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required>
  </div>

  <div class="mb-3">
    <label for="rol" class="form-label">Rol</label>
    <select class="form-select" id="rol" name="rol" required>
      <option value="">Seleccione un rol</option>
      <option value="Administrador">Administrador</option>
      <option value="Técnico">Técnico</option>
      <option value="Invitado">Invitado</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-1"></i> Guardar usuario
  </button>
  <a href="?view=usuarios" class="btn btn-secondary ms-2">Cancelar</a>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
?>
