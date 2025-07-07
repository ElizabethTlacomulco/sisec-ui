<!-- Topbar -->
<header class="topbar">
  <!-- Botón hamburguesa móvil -->
  <button class="btn btn-link text-white d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Abrir menú">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Título -->
  <h5 class="m-0 flex-grow-1"><?= htmlspecialchars($pageHeader ?? 'SISEC') ?></h5>

  <!-- Íconos de notificación y usuario -->
  <?php
  $notificaciones = [];
  $notificaciones_no_vistas = 0;

  if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'Administrador') {
      if (!isset($conn)) {
          include __DIR__ . '/db.php';
      }

      $sql = "SELECT * FROM notificaciones ORDER BY fecha DESC LIMIT 5";
      $result = $conn->query($sql);

      if ($result) {
          while ($row = $result->fetch_assoc()) {
              $notificaciones[] = $row;
              if ($row['visto'] == 0) {
                  $notificaciones_no_vistas++;
              }
          }
      }
  }
  ?>

  <div class="topbar-icons">
    <div class="dropdown position-relative" title="Notificaciones">
      <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'Administrador'): ?>
        <a href="#" id="notifDropdown" class="text-white" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none; position:relative;">
          <i class="fas fa-bell"></i>
          <?php if ($notificaciones_no_vistas > 0): ?>
            <span class="notification-badge"></span>
          <?php endif; ?>
        </a>

        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width: 300px;">
          <?php if (count($notificaciones) === 0): ?>
            <li class="dropdown-item text-center text-muted">No hay notificaciones</li>
          <?php else: ?>
            <?php foreach ($notificaciones as $notif): ?>
              <li class="dropdown-item<?= $notif['visto'] == 0 ? ' fw-bold' : '' ?>" style="white-space: normal;">
                <?= htmlspecialchars($notif['mensaje']) ?><br>
                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($notif['fecha'])) ?></small>
              </li>
              <li><hr class="dropdown-divider"></li>
            <?php endforeach; ?>
            <li><a href="/sisec-ui/views/notificaciones/notificaciones.php" class="dropdown-item text-center">Ver todas</a></li>
          <?php endif; ?>
        </ul>
      <?php else: ?>
        <i class="fas fa-bell" style="opacity:0.5;"></i>
      <?php endif; ?>
    </div>
  </div>

  <!-- Dropdown usuario -->
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-photo">
        <?php if (!empty($_SESSION['foto']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $_SESSION['foto'])): ?>
          <img src="<?= htmlspecialchars($_SESSION['foto']) ?>" alt="foto">
        <?php else: ?>
          <i class="fas fa-user-circle fa-2x text-white"></i>
        <?php endif; ?>
      </div>
      <span class="user-name d-none d-sm-inline"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
      <li><a class="dropdown-item" href="/sisec-ui/views/usuarios/perfil.php"><i class="fas fa-user me-2"></i>Perfil</a></li>
      <li><a class="dropdown-item" href="/sisec-ui/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
    </ul>
  </div>
</header>
