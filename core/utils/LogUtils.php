<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;


use Exception;

/**
 * Class LogUtils
 *
 * @package core\utils
 */
final class LogUtils
{

    public static function writeConsole($content)
    {
        if ($GLOBALS["DEBUG"] == false) {
            return;
        }
        echo "<script type='text/javascript'>console.log('$content');</script>";
    }

    /**
     * @param string      $fileName
     * @param string      $content
     * @param string|null $customPath
     */
    public static function logFile($fileName, $content, $customPath = null)
    {
        try {
            $pathFile = W_LOG;
            if (!empty($customPath)) {
                $pathFile .= DIRECTORY_SEPARATOR . $customPath;
            }
            if (!file_exists($pathFile)) {
                if (!mkdir($pathFile, 0755, true)) {
                    throw new Exception(
                        'Could not create directory: '
                        . $pathFile
                    );
                }
            }
            $pathFile .= DIRECTORY_SEPARATOR . date('Ymd-') . $fileName;

            $f = fopen($pathFile, 'a');
            if (!$f) {
                throw new Exception('Could not write log file: ' . $pathFile);
            }
            fwrite($f, date('d-m-Y H:i:s') . '||' . $content);
            fwrite($f, "\n");
            fclose($f);
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}