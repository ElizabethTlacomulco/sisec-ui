<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISEC - <?= htmlspecialchars($pageTitle ?? 'Página') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      background: linear-gradient(to bottom, #20c6c6, #1a9e9e);
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
    }
    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      color: white;
      padding: 12px 20px;
      display: block;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .sidebar i {
      margin-right: 10px;
    }

    .topbar {
      margin-left: 220px;
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #ccc;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .main {
      margin-left: 220px;
      padding: 30px;
    }

    .topbar-right i {
      font-size: 18px;
      margin-left: 20px;
      cursor: pointer;
    }

    .topbar-right img {
      width: 36px;
      height: 36px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4><i class="fas fa-user-circle"></i> SISEC</h4>
    <a href="index.php" class="<?= ($activePage ?? '') === 'inicio' ? 'active' : '' ?>"><i class="fas fa-home"></i> Inicio</a>
    <a href="listar.php" class="<?= ($activePage ?? '') === 'dispositivos' ? 'active' : '' ?>"><i class="fas fa-camera"></i> Dispositivos</a>
    <a href="registro.php" class="<?= ($activePage ?? '') === 'registro' ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> Registrar</a>
    <a href="usuarios\index.php" class="<?= ($activePage ?? '') === 'usuarios' ? 'active' : '' ?>"><i class="fas fa-user"></i> Usuarios</a>
    <a href="#" class="<?= ($activePage ?? '') === 'reportes' ? 'active' : '' ?>"><i class="fas fa-folder"></i> Reportes</a>
  </div>

  '/../../includes/conexion.php'
  <!-- Topbar -->
  <div class="topbar">
    <div><h5 class="m-0"><?= htmlspecialchars($pageHeader ?? 'SISEC') ?></h5></div>
    <div class="topbar-right d-flex align-items-center">
      <i class="fas fa-bell"></i>
      <i class="fas fa-cog"></i>
      <img src="https://i.pravatar.cc/36" alt="Perfil">
    </div>
  </div>

  <!-- Contenido principal -->
  <main class="main">
    <?= $content ?? '<p>Contenido no definido.</p>' ?>
  </main>

</body>
</html>
