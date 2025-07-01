<?php
session_start();
include __DIR__ . '/../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = $_POST['usuario'] ?? '';
  $clave = $_POST['clave'] ?? '';

  // Consulta al usuario
  $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows === 1) {
    $user = $resultado->fetch_assoc();

    // Compara la contraseña (usa MD5 si así la guardaste, o mejor con password_verify si usas hash seguro)
    if ($user['clave'] === md5($clave)) {
      $_SESSION['usuario'] = $user['usuario'];
      $_SESSION['nombre'] = $user['nombre'];
      $_SESSION['rol'] = $user['rol'];
      $_SESSION['id'] = $user['id'];

      header("Location: ../index.php");
      exit;
    }
  }

  // Si llegó aquí es porque falló
  header("Location: ../login.php?error=Credenciales incorrectas");
  exit;
}
