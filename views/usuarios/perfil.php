<?php
require_once __DIR__ . '/../../includes/auth.php';
verificarAutenticacion(); // Verifica sesión iniciada

$pageTitle = "Mi perfil";
$pageHeader = "Perfil de usuario";
$activePage = "perfil";

ob_start();
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm p-4">
        <h4 class="mb-3 text-center">Mi perfil</h4>

        <div class="text-center mb-3">
          <?php if (!empty($_SESSION['foto'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" class="rounded-circle" width="100" height="100" alt="Foto de perfil">
          <?php else: ?>
            <i class="fas fa-user-circle fa-5x text-secondary"></i>
          <?php endif; ?>
        </div>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></p>
        <p><strong>Rol:</strong> <?= htmlspecialchars($_SESSION['usuario_rol']) ?></p>

        <div class="text-center mt-4">
          <a href="/sisec-ui/views/usuarios/editar_perfil.php" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Editar perfil
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.php';
?>
