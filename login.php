<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit;
}

$mensaje = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - SISEC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #a4d8ef, #74c3d1);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-box {
      background: #20c6c6;
      color: white;
      padding: 40px 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .login-box h2 {
      font-weight: bold;
      text-align: center;
      margin-bottom: 10px;
    }

    .login-box p {
      text-align: center;
      font-size: 14px;
      margin-bottom: 30px;
    }

    .login-box .form-control {
      background: white;
      border: none;
      border-radius: 4px;
      padding: 10px 12px;
    }

    .login-box .form-check-label {
      color: white;
    }

    .btn-login {
      width: 100%;
      background: linear-gradient(to right, #0066cc, #3399ff);
      border: none;
      color: white;
      font-weight: bold;
      padding: 10px;
      border-radius: 25px;
    }

    .btn-login:hover {
      background: #005bb5;
    }

    .login-box small {
      display: block;
      margin-top: 10px;
      text-align: right;
      color: white;
    }

    .input-group-text {
      background: white;
      border: none;
    }
  </style>
</head>
<body>

  <form class="login-box" method="POST" action="controllers/AuthController.php">
    <h2>SISEC</h2>
    <p>Sistema de seguridad y comunicaciones</p>

    <?php if ($mensaje): ?>
      <div class="alert alert-danger py-1 text-center"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-user"></i></span>
      <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
    </div>

    <div class="mb-3 input-group">
      <span class="input-group-text"><i class="fas fa-key"></i></span>
      <input type="password" name="clave" class="form-control" placeholder="Contraseña" required>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="recordar" id="recordar">
      <label class="form-check-label" for="recordar">
        Mantener sesión iniciada
      </label>
    </div>

    <button type="submit" class="btn btn-login">INICIA SESIÓN</button>

    <small><a href="#" class="text-light text-decoration-none">¿Olvidaste tu contraseña?</a></small>
  </form>

</body>
</html>
