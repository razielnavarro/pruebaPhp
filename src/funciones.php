<?php

function obtenerUsuariosConCache($pdo) {
    $cacheFile = 'cache/usuarios_cache.php';

    // Verifica si existe el archivo de caché y no ha expirado
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
        return include($cacheFile); // Devuelve los datos del caché
    }

    // Si el caché no existe o ha expirado, consulta la base de datos
    $stmt = $pdo->prepare("SELECT id, nombre, correo FROM usuarios");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Guarda el resultado en caché
    file_put_contents($cacheFile, '<?php return ' . var_export($usuarios, true) . ';');

    return $usuarios;
}
