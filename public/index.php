<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../core/App.php';
require_once __DIR__ . '/../core/Controller.php';

// ... resto de tu código

spl_autoload_register(function ($class) {
    $classParts = explode('\\', $class);

    if (count($classParts) > 1 && strtolower($classParts[0]) === 'app') {
        array_shift($classParts);
        $className = array_pop($classParts);
        $subfolders = array_map('strtolower', $classParts);
        
        $path = implode(DIRECTORY_SEPARATOR, $subfolders);
        $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
});

use Core\App;

$app = new App();