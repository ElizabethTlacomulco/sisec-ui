<?php
session_start();
require_once __DIR__ . '/../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);

    if (empty($nombre) || empty($password)) {
        header('Location: ../login.php?error=' . urlencode("Por favor, completa todos los campos."));
        exit;
    }

    // Buscar al usuario por nombre completo
    $stmt = $pdo->prepare("SELECT id, nombre, clave FROM usuarios WHERE nombre = ?");
    $stmt->execute([$nombre]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['clave'])) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];

    if ($remember) {
        setcookie('usuario_id', $usuario['id'], time() + (7 * 24 * 60 * 60), "/");
    }

    header("Location: ../index.php"); // ← redirige al panel principal
    exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}
