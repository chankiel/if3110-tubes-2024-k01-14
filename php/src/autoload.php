<?php
spl_autoload_register(function ($class) {
    // Define the base directory for your classes
    $baseDir = __DIR__ . '/';

    // Replace namespace separators with directory separators for file path
    $classPath = str_replace('\\', '/', $class);

    // Append the .php extension and construct the full file path
    $file = $baseDir . $classPath . '.php';

    // Check if the file exists and include it
    if (file_exists($file)) {
        require_once $file;
    } else {
        die("The class file for $class could not be found: $file");
    }
});
