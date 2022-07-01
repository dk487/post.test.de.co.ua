<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(fn($class) =>
    require __DIR__ . '/src/' . strtr($class, '\\', '/') . '.php'
);
