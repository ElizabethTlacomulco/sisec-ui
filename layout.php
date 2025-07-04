<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISEC - <?= htmlspecialchars($pageTitle ?? 'Página') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
    }

    .topbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background: linear-gradient(to right, #20c6c6, #1a9e9e);
      color: white;
      border-bottom: 1px solid #ccc;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 1040;
    }

    .sidebar {
      width: 220px;
      top: 60px;
      height: calc(100vh - 60px);
      background-color: #ffffff;
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

    .main {
      padding: 30px;
      margin-top: 60px;
    }

    @media (min-width: 768px) {
      .main {
        margin-left: 220px;
      }
    }

    .topbar-right i {
      font-size: 18px;
      margin-left: 20px;
      cursor: pointer;
      color: white;
    }

    .topbar-right img {
      width: 36px;
      height: 36px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <!-- Topbar -->
  <div class="topbar w-100">
    <div class="d-flex align-items-center gap-3">
      <!-- Botón menú móvil -->
      <button class="btn btn-sm btn-light d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
        <i class="fas fa-bars"></i>
      </button>
      <h5 class="m-0 text-white"><?= htmlspecialchars($pageHeader ?? 'SISEC') ?></h5>
    </div>
    <div class="topbar-right d-flex align-items-center">
      <i class="fas fa-bell"></i>
      <i class="fas fa-cog"></i>
      <img src="https://i.pravatar.cc/36" alt="Perfil">
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar d-none d-md-flex flex-column justify-content-between">
    <div>
      <h4><i class="fas fa-user-circle"></i> SISEC</h4>
      <a href="/sisec-ui/views/inicio/index.php" class="<?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>"><i class="fas fa-home"></i> Inicio</a>
      <a href="/sisec-ui/views/dispositivos/listar.php" class="<?= ($activePage ?? '') === 'dispositivos' ? 'active' : '' ?>"><i class="fas fa-camera"></i> Dispositivos</a>
      <a href="/sisec-ui/views/dispositivos/registro.php" class="<?= ($activePage ?? '') === 'registro' ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> Registrar dispositivo</a>
      <a href="/sisec-ui/views/usuarios/index.php" class="<?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Usuarios</a>
      <a href="/sisec-ui/views/usuarios/registrar.php" class="<?= ($activePage ?? '') === 'registrar' ? 'active' : '' ?>"><i class="fa-solid fa-user-plus"></i> Registrar usuario</a>
    </div>
    <?php if (isset($_SESSION['usuario_id'])): ?>
      <div class="mt-auto">
        <a href="/sisec-ui/logout.php" class="text-dark px-3 py-2 d-block text-start">
          <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
        </a>
      </div>
    <?php endif; ?>
  </div>

  <!-- Contenido principal -->
  <main class="main">
    <?= $content ?? '<p>Contenido no definido.</p>' ?>
  </main>

  <!-- Sidebar móvil (offcanvas) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" style="background-color: #ffffff;">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title text-primary"><i class="fas fa-user-circle me-2"></i>SISEC</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
      <div>
        <a href="/sisec-ui/views/inicio/index.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fas fa-home me-2"></i>Inicio</a>
        <a href="/sisec-ui/views/dispositivos/listar.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fas fa-camera me-2"></i>Dispositivos</a>
        <a href="/sisec-ui/views/dispositivos/registro.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fas fa-plus-circle me-2"></i>Registrar dispositivo</a>
        <a href="/sisec-ui/views/usuarios/index.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fa-solid fa-users me-2"></i>Usuarios</a>
        <a href="/sisec-ui/views/usuarios/registrar.php" class="d-block mb-2 text-dark text-decoration-none"><i class="fa-solid fa-user-plus me-2"></i>Registrar usuario</a>
      </div>
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="mt-3">
          <hr>
          <a href="/sisec-ui/logout.php" class="d-block text-danger text-decoration-none">
            <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>


</body>
</html>
