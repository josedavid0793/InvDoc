<?php
// Guardar como diagnostic.php en la raíz de tu proyecto Laravel

echo "Diagnóstico de Laravel\n";
echo "=====================\n\n";

echo "Versión de PHP: " . PHP_VERSION . "\n";

echo "\nExtensiones de PHP instaladas:\n";
print_r(get_loaded_extensions());

echo "\nContenido de composer.json:\n";
echo file_get_contents('composer.json');

echo "\nContenido de config/app.php:\n";
echo file_get_contents('config/app.php');

echo "\nVerificando la existencia de archivos y directorios clave:\n";
$files_to_check = [
    'vendor',
    'composer.lock',
    '.env',
    'app/Providers/AppServiceProvider.php',
    'config/app.php'
];

foreach ($files_to_check as $file) {
    echo $file . ': ' . (file_exists($file) ? 'Existe' : 'No existe') . "\n";
}

echo "\nÚltimas líneas del log de Laravel:\n";
$log_file = 'storage/logs/laravel.log';
if (file_exists($log_file)) {
    $log_contents = file($log_file);
    $last_lines = array_slice($log_contents, -20);
    echo implode('', $last_lines);
} else {
    echo "Archivo de log no encontrado.\n";
}