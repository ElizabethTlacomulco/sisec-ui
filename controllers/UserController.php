<?php
include __DIR__ . '/../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'crear') {
  $nombre = $_POST['nombre'];
  $rol = $_POST['rol'];

  $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, rol) VALUES (?, ?)");
  $stmt->bind_param("ss", $nombre, $rol);
  $stmt->execute();

  header("Location: ../index.php?views=usuarios");
  exit;
}

if ($_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $conexion->query("DELETE FROM usuarios WHERE id = $id");
  header("Location: ../index.php?views=usuarios");
  exit;
}

// Actualizar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar') {
  $id = intval($_POST['id']);
  $nombre = $_POST['nombre'];
  $rol = $_POST['rol'];

  $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, rol = ? WHERE id = ?");
  $stmt->bind_param("ssi", $nombre, $rol, $id);
  $stmt->execute();

  header("Location: ../index.php?views=usuarios");
  exit;
}
