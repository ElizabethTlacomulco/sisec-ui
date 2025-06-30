<?php
$host = 'localhost';        // Servidor
$usuario = 'root';          // Usuario de MySQL por defecto en XAMPP
$clave = '';                // Sin contraseña por defecto
$bd = 'sisec';              // Nombre de tu base de datos

$conexion = new mysqli($host, $usuario, $clave, $bd);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}
?>
