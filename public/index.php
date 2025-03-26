<?php

$cacheFile = 'cache/' . md5($_SERVER['REQUEST_URI']) . '.html';

// Verifica si el caché de la página existe y no ha expirado
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
    echo file_get_contents($cacheFile);
    exit;
}

ob_start(); // Comienza a capturar la salida HTML

// Aquí iría el contenido dinámico de la página (ejemplo: listado de usuarios)
require '../src/funciones.php';
$usuarios = obtenerUsuariosConCache($pdo);

echo "<h1>Usuarios</h1>";
foreach ($usuarios as $usuario) {
    echo "<p>{$usuario['nombre']} - {$usuario['correo']}</p>";
}

$content = ob_get_contents();
file_put_contents($cacheFile, $content); // Guardar la página en caché
ob_end_flush(); // Imprimir el contenido
?>
