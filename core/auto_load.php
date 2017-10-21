<?php

namespace core;

use Exception;


spl_autoload_register( __NAMESPACE__ . '\autoLoad' );

/**
 * @param string $className
 */
function autoLoad($className)
{
    try {
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = trim($fileName, '/');
        $fileName .= '.php';
        /*$className = ltrim($className, '\\');
        $fileName = '';
        $namespace = null;
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';*/

        if (!file_exists($fileName)) {
            throw new Exception('Could not find file ' . $fileName);
        }
        /**
         * @define $fileName "core/processor/System.php"
         */
        require $fileName;
    } catch (Exception $e) {
        exit('Caught Exception: ' . $e->getMessage());
    }
}