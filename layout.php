<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/includes/head.php'; ?>

  <meta charset="UTF-8" />
  <title>SISEC - <?= htmlspecialchars($pageTitle ?? 'Página') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS y FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/sisec-ui/assets/css/estilos.css">

<body>

  <!-- Topbar -->

  <?php include __DIR__ . '/includes/topbar.php'; ?>

  <!-- Sidebar fijo desktop -->
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <!-- Contenido principal -->
  <main class="main">
    <?= $content ?? '<p>Contenido no definido.</p>' ?>
  </main>

  <!-- Sidebar móvil (offcanvas) -->
    <?php include __DIR__ . '/includes/sidebar_mobile.php'; ?>

    <script src="/sisec-ui/assets/js/notificaciones.js"></script>


  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>