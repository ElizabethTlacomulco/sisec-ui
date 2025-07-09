<?php
if (!isset($_GET['Equipo'])) {
    header("Location: elegir_dispositivo.php");
    exit;
}

$Equipo = strtolower($_GET['Equipo']);

switch ($Equipo) {
    case 'camara':
        header("Location: registro.php"); // Tu formulario actual
        break;
    default:
        echo "El formulario para '$Equipo' aún no está disponible.";
        break;
}
exit;

