<?php
/**
 * Load a Caliper class file based on its name.
 *
 * @param string $className Fully-qualified name of class to be loaded
 */
$loadCaliperClass = function ($className) {
    /** @var string $classBaseDirectory Base directory for class files, i.e., "./src/" */
    $classBaseDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;

    // If the class name begins with "IMSGlobal\Caliper\", remove it
    if (strpos($className, 'IMSGlobal\\Caliper\\') === 0) {
        $className = substr($className, 18);
    }

    // Construct the class' filename from the class base directory, the class name
    // with slashes replaced by the OS-specific directory separator character, and
    // the ".php" extension
    /** @var string $classFileFullPath */
    $classFileFullPath = $classBaseDirectory .
        str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $className) . '.php';

    // If the class file exists, require it, but only once
    if (file_exists($classFileFullPath)) {
        require_once $classFileFullPath;
    }
};

spl_autoload_register($loadCaliperClass);
