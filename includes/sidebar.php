<!-- Sidebar fijo desktop -->
<nav class="sidebar d-none d-md-flex flex-column justify-content-between">
  <div>
    <h4><i class="fas fa-user-circle"></i> SISEC</h4>

    <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
      <a href="/sisec-ui/views/inicio/index.php" class="<?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>">
        <i class="fas fa-home"></i> Inicio
      </a>
    <?php endif; ?>

    <a href="/sisec-ui/views/dispositivos/listar.php" class="<?= ($activePage ?? '') === 'dispositivos' ? 'active' : '' ?>">
      <i class="fas fa-camera"></i> Dispositivos
    </a>

    <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
      <a href="/sisec-ui/views/dispositivos/elegir_dispositivo.php" class="<?= ($activePage ?? '') === 'registro' ? 'active' : '' ?>">
        <i class="fas fa-plus-circle"></i> Registrar dispositivo
      </a>
    <?php endif; ?>

    <?php if ($_SESSION['usuario_rol'] === 'Administrador'): ?>
      <a href="/sisec-ui/views/usuarios/index.php" class="<?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>">
        <i class="fa-solid fa-users"></i> Usuarios
      </a>
      <a href="/sisec-ui/views/usuarios/registrar.php" class="<?= ($activePage ?? '') === 'registrar' ? 'active' : '' ?>">
        <i class="fa-solid fa-user-plus"></i> Registrar usuario
      </a>
    <?php endif; ?>
  </div>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="mt-auto">
      <a href="/sisec-ui/logout.php" class="text-dark px-3 py-2 d-block text-start">
        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
      </a>
    </div>
  <?php endif; ?>
</nav>
