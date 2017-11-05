<?php

namespace core;

use Exception;


spl_autoload_register(__NAMESPACE__ . '\autoLoad');

/**
 * @param string $className
 */
function autoLoad($className)
{
    try {
        if (!preg_match('/^(core|apps)/', $className)) {
            return;
        }
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = trim($fileName, DIRECTORY_SEPARATOR);
        $fileName .= '.php';

        if (!file_exists($fileName)) {
            throw new Exception('Could not find file ' . $fileName);
        }
        /** @noinspection PhpIncludeInspection */
        require_once $fileName;
        if (method_exists($className, '_init')) {
            /** @noinspection PhpUndefinedMethodInspection */
            $className::_init();
        }
    } catch (Exception $e) {
        exit('Caught Exception: ' . $e->getMessage());
    }
}