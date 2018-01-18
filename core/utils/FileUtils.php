<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;

use DOMDocument;
use DOMXPath;
use Exception;
use SimpleXMLElement;

/**
 * Class FileUtils
 *
 * @package core\utils
 */
final class FileUtils
{
    const DEFAULT_NS_PREFIX = 'ns';

    /**
     * FileUtils constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param SimpleXMLElement $source
     * @param SimpleXMLElement $destination
     *
     * @return SimpleXMLElement
     */
    public static function mergeXMLObject(SimpleXMLElement $source = null,
        SimpleXMLElement $destination = null
    ) {
        if (!empty($source)) {
            $dom1 = new DomDocument();
            $dom2 = new DomDocument();

            $dom1->loadXML($source->asXML());
            $dom2->loadXML($destination->asXML());

            // pull all child elements of second XML
            $xpath = new domXPath($dom2);
            $xpathQuery = $xpath->query('/*/*');

            for ($i = 0; $i < $xpathQuery->length; $i++) {
                // and pump them into first one
                $dom1->documentElement->appendChild(
                    $dom1->importNode($xpathQuery->item($i), true)
                );
            }

            $source = simplexml_import_dom($dom1);
        } else {
            $source = $destination;
        }

        return $source;
    }

    /**
     * @param        $filePath
     * @param string $namespacePrefix
     *
     * @return SimpleXMLElement
     */
    public static function readXMLFile($filePath,
        $namespacePrefix = self::DEFAULT_NS_PREFIX
    ) {
        try {
            if (!file_exists($filePath)) {
                throw new Exception('Could not find file: ' . $filePath);
            }
            $fileContent = simplexml_load_file(
                $filePath, 'SimpleXMLElement',
                LIBXML_NOCDATA
            );
            if (!$fileContent) {
                throw new Exception('Could not read file: ' . $filePath);
            }
            foreach (
                $fileContent->getDocNamespaces() as $strPrefix => $strNamespace
            ) {
                if (strlen($strPrefix) == 0) {
                    $strPrefix
                        = $namespacePrefix; //Assign an arbitrary namespace prefix.
                }
                $fileContent->registerXPathNamespace($strPrefix, $strNamespace);
            }

            return $fileContent;
        } catch (Exception $e) {
            exit("Caught Exception: " . $e->getMessage());
        }
    }

    /**
     * @param        $files
     * @param        $rootName
     * @param string $directory
     *
     * @return SimpleXMLElement
     * @throws Exception
     */
    public static function readMultipleXMLFile($files, $rootName,
        $directory = W_APPS
    ) {
        $dom = new DOMDocument();
        $dom->appendChild($dom->createElement($rootName));

        foreach ($files as $filename) {
            $filename = trim($filename, ' /');
            $filename = $directory . DIRECTORY_SEPARATOR . $filename;
            if (!file_exists($filename)) {
                throw new Exception('Could not find file: ' . $filename);
            }
            $addDom = new DOMDocument();
            $addDom->load($filename);
            if ($addDom->documentElement) {
                foreach ($addDom->documentElement->childNodes as $node) {
                    $dom->documentElement->appendChild(
                        $dom->importNode($node, true)
                    );
                }
            }
        }

        return simplexml_import_dom($dom);

    }

    /**
     * @param $filePath
     *
     * @return array
     */
    public static function getSQLFileContent($filePath)
    {
        try {
            if (!file_exists($filePath)) {
                throw new Exception('Could not find file: ' . $filePath);
            }
            $result = Array();
            $fd = fopen($filePath, 'rb');
            while (($line = fgets($fd)) !== false) {
                $line = trim($line);
                if ($line == '') {
                    continue;
                }
                $line = explode('=', $line, 2);
                if (count($line) < 2) {
                    throw new Exception('Could not read file: ' . $filePath);
                }
                $result[trim($line[0])] = trim($line[1]);
            }
            fclose($fd);

            return $result;
        } catch (Exception $e) {
            exit("Caught Exception: " . $e->getMessage());
        }
    }

    public static function getFileContent($filePath)
    {
        try {
            if (!file_exists($filePath)) {
                throw new Exception('Could not find file: ' . $filePath);
            }
            $fileContent = file_get_contents($filePath);
            if ($fileContent === false) {
                throw new Exception('Could not read file: ' . $filePath);
            }

            return $fileContent;
        } catch (Exception $e) {
            exit("Caught Exception: " . $e->getMessage());
        }
    }

    /**
     * @param string $filePath
     *
     * @return array|bool
     */
    public static function readINIFile($filePath)
    {
        try {
            if (!file_exists($filePath)) {
                throw new Exception('Could not find file: ' . $filePath);
            }
            $fileContent = parse_ini_file($filePath, true, INI_SCANNER_RAW);
            if ($fileContent === false) {
                throw new Exception('Could not read file: ' . $filePath);
            }

            return $fileContent;
        } catch (Exception $e) {
            exit("Caught Exception: " . $e->getMessage());
        }
    }

    /**
     * @param array $file
     * @param       $path
     * @param       $name
     *
     * @return bool|mixed|string
     */
    public static function uploadFile(array $file, $path, $name = null)
    {
        try {
            if ($file['error'] != UPLOAD_ERR_OK) {
                return false;
            }

            /**
             * Check if upload directory already exist
             */
            if (!file_exists($path)) {
                if (!mkdir($path, 0755, true)) {
                    return false;
                }
            }

            $tmpName = $file["tmp_name"];
            if (empty($name)) {
                $name = self::validateFileName(
                    basename($file["name"])
                );
            }
            if (!move_uploaded_file($tmpName, "$path/$name")) {
                return false;
            }
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }

        return $name;
    }

    /**
     * @param string $fileName
     *
     * @return mixed|string
     */
    public static function validateFileName($fileName)
    {
        $fileName = preg_replace('/[^\.a-zA-Z0-9_-]/', '', $fileName);
        $fileName = mb_strtolower($fileName, "UTF-8");
        return $fileName;
    }

    public static function validateDirectory($pathName)
    {
        $pathName = preg_replace('/[^\.a-zA-Z0-9_-]/', '-', $pathName);
        return $pathName;
    }

    /**
     * @param array $file
     * @param array $extensionsAllowed
     * @param array $typeAllowed
     *
     * @return bool
     */
    public static function checkFileType(array $file, array $extensionsAllowed,
        array $typeAllowed
    ) {
        $name = $file['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (!in_array($ext, $extensionsAllowed)) {
            return false;
        }
        if (!in_array($file['type'], $typeAllowed)) {
            return false;
        }

        return true;
    }

    /**
     * @param $content
     * @param $path
     */
    public static function writeTruncateFile($content, $path)
    {
        try {
            $dir = explode(DIRECTORY_SEPARATOR, $path);
            array_pop($dir);
            $dir = implode(DIRECTORY_SEPARATOR, $dir);
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0755, true)) {
                    throw new Exception('Could not create dir: ' . $dir);
                }
            }
            $f = fopen($path, 'w+');
            if (!$f) {
                throw new Exception('Could not write file: ' . $path);
            }
            fwrite($f, $content);
            fclose($f);
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}