<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>SISEC - <?= htmlspecialchars($pageTitle ?? 'Página') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS y FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
    }

    /* Topbar fijo */
    .topbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 60px;
      background: linear-gradient(to right, #20c6c6, #1a9e9e);
      color: white;
      border-bottom: 1px solid #ccc;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 1040;
      width: 100%;
    }

    /* Sidebar fijo desktop */
    .sidebar {
      width: 220px;
      top: 60px;
      height: calc(100vh - 60px);
      background-color: #fff;
      color: #333;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      position: fixed;
      z-index: 1030;
      border-right: 1px solid #ddd;
    }

    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
      color: #20c6c6;
    }

    .sidebar a {
      color: #333;
      padding: 12px 20px;
      display: block;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #f0f0f0;
    }

    .sidebar i {
      margin-right: 10px;
    }

    /* Contenido principal */
    main.main {
      margin-left: 220px;
      padding: 30px;
      padding-top: 80px; /* para no quedar debajo del topbar */
      min-height: 100vh;
      background-color: #f9f9f9;
    }

    /* Iconos y foto en topbar */
    .topbar .topbar-icons {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .topbar .topbar-icons i {
      font-size: 1.25rem;
      cursor: pointer;
      color: white;
      position: relative;
    }

    /* Burbuja roja notificación */
    .topbar .topbar-icons .notification-badge {
      position: absolute;
      top: 0;
      right: -6px;
      width: 10px;
      height: 10px;
      background: #dc3545;
      border-radius: 50%;
      border: 1.5px solid white;
    }

    /* Foto de usuario */
    .topbar .user-photo {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 2px solid #eee;
      overflow: hidden;
      margin-right: 8px;
    }

    .topbar .user-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Ocultar texto usuario en pantallas xs */
    .topbar .user-name {
      color: white;
      font-weight: 500;
    }
    .topbar .user-name.d-none.d-sm-inline {
      display: none;
    }
    @media (min-width: 576px) {
      .topbar .user-name.d-none.d-sm-inline {
        display: inline;
      }
    }

    /* Sidebar solo desktop */
    @media (max-width: 767.98px) {
      .sidebar {
        display: none !important;
      }

      main.main {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Topbar -->
  <header class="topbar">
    <!-- Botón hamburguesa móvil -->
    <button class="btn btn-link text-white d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Abrir menú">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Título -->
    <h5 class="m-0 flex-grow-1"><?= htmlspecialchars($pageHeader ?? 'SISEC') ?></h5>

    <!-- Íconos de notificación y usuario -->
    <div class="topbar-icons">
      <div class="position-relative" title="Notificaciones">
        <i class="fas fa-bell"></i>
        <span class="notification-badge"></span>
      </div>

      <!-- Dropdown usuario -->
      <div class="dropdown">
        <a href="/views/perfil.php" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <?php if (!empty($u['foto']) && file_exists(__DIR__ . "/../../uploads/usuarios/" . $u['foto'])): ?>
            <img src="/sisec-ui/uploads/usuarios/<?= htmlspecialchars($u['foto']) ?>" alt="foto" width="40" height="40" class="rounded-circle">
          <?php else: ?>
            <i class="fas fa-user-circle fa-2x text-secondary"></i>
          <?php endif; ?>

          <span class="user-name d-none d-sm-inline"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="/sisec-ui/views/usuarios/perfil.php"><i class="fas fa-user me-2"></i>Perfil</a>
          <li><a class="dropdown-item" href="/sisec-ui/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
        </ul>
      </div>
    </div>
  </header>

  <!-- Sidebar fijo desktop -->
  <nav class="sidebar d-none d-md-flex flex-column justify-content-between">
    <div>
      <h4><i class="fas fa-user-circle"></i> SISEC</h4>
      <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
        <a href="/sisec-ui/views/inicio/index.php" class="<?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>"><i class="fas fa-home"></i> Inicio</a>
      <?php endif; ?>
      <a href="/sisec-ui/views/dispositivos/listar.php" class="<?= ($activePage ?? '') === 'dispositivos' ? 'active' : '' ?>"><i class="fas fa-camera"></i> Dispositivos</a>
      <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
        <a href="/sisec-ui/views/dispositivos/registro.php" class="<?= ($activePage ?? '') === 'registro' ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> Registrar dispositivo</a>
      <?php endif; ?>
      <?php if ($_SESSION['usuario_rol'] === 'Administrador'): ?>
        <a href="/sisec-ui/views/usuarios/index.php" class="<?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Usuarios</a>
        <a href="/sisec-ui/views/usuarios/registrar.php" class="<?= ($activePage ?? '') === 'registrar' ? 'active' : '' ?>"><i class="fa-solid fa-user-plus"></i> Registrar usuario</a>
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

  <!-- Contenido principal -->
  <main class="main">
    <?= $content ?? '<p>Contenido no definido.</p>' ?>
  </main>

  <!-- Sidebar móvil (offcanvas) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel" style="background-color: #fff;">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title text-primary" id="mobileMenuLabel"><i class="fas fa-user-circle me-2"></i>SISEC</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <div>
        <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
          <a href="/sisec-ui/views/inicio/index.php" 
            class="d-block mb-2 text-dark text-decoration-none <?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>">
            <i class="fas fa-home me-2"></i>Inicio
          </a>
        <?php endif; ?>

        <a href="/sisec-ui/views/dispositivos/listar.php" 
          class="d-block mb-2 text-dark text-decoration-none <?= ($activePage ?? '') === 'dispositivos' ? 'active' : '' ?>">
          <i class="fas fa-camera me-2"></i>Dispositivos
        </a>

        <?php if (in_array($_SESSION['usuario_rol'], ['Administrador', 'Técnico'])): ?>
          <a href="/sisec-ui/views/dispositivos/registro.php" 
            class="d-block mb-2 text-dark text-decoration-none <?= ($activePage ?? '') === 'registro' ? 'active' : '' ?>">
            <i class="fas fa-plus-circle me-2"></i>Registrar dispositivo
          </a>
        <?php endif; ?>

        <?php if ($_SESSION['usuario_rol'] === 'Administrador'): ?>
          <a href="/sisec-ui/views/usuarios/index.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fa-solid fa-users me-2"></i>Usuarios</a>
          <a href="/sisec-ui/views/usuarios/registrar.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fa-solid fa-user-plus me-2"></i>Registrar usuario</a>
        <?php endif; ?>
      </div>

      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="mt-3">
          <hr />
          <a href="/sisec-ui/logout.php" class="d-block text-danger text-decoration-none">
            <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
