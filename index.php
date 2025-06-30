<?php
// index.php principal: carga vistas según ?view=...

$view = $_GET['view'] ?? 'dashboard'; // Vista por defecto

$allowedViews = [
  'dashboard'           => 'views/index.php',
  'registro'            => 'views/registro.php',
  'listar'              => 'views/listar.php',
  'usuarios'            => 'views/usuarios/index.php',
  'usuarios_registrar'  => 'views/usuarios/registrar.php',
  'usuarios_editar'     => 'views/usuarios/editar.php',
  // Agrega aquí más vistas cuando las tengas
];

if (array_key_exists($view, $allowedViews)) {
  include $allowedViews[$view];
} else {
  http_response_code(404);
  echo "<h2 style='padding:2rem;'>❌ Vista no encontrada</h2>";
}
