<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 10/18/17
 * Time: 10:13 AM
 */

namespace core\utils;


use Exception;
use SimpleXMLElement;

class ValueList
{
    const NAMESPACE_PREFIX = 'ns';
    /**
     * @var SimpleXMLElement $lists
     */
    private $lists;

    /**
     * ValueList constructor.
     *
     * @param $fileName
     */
    public function __construct($fileName)
    {
        try {
            $list = Cache::get("list:{$fileName}");
            if (!$list) {
                $filePath = Properties::getPropertiesLocation()
                    . DIRECTORY_SEPARATOR . $fileName;
                $list = FileUtils::readXMLFile(
                    $filePath, self::NAMESPACE_PREFIX
                );

                Cache::set("list:{$fileName}", $list->asXML());
            } else {
                $list = new SimpleXMLElement($list);
                foreach (
                    $list->getDocNamespaces() as $strPrefix => $strNamespace
                ) {
                    if (strlen($strPrefix) == 0) {
                        $strPrefix
                            = self::NAMESPACE_PREFIX; //Assign an arbitrary namespace prefix.
                    }
                    $list->registerXPathNamespace($strPrefix, $strNamespace);
                }
            }

            $this->lists = $list;
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     * @return SimpleXMLElement[]
     */
    public function getAll()
    {
        $prefix = self::NAMESPACE_PREFIX;
        return $this->lists->xpath("//{$prefix}:node");
    }

    /**
     * @return SimpleXMLElement[]
     */
    public function getAllKey()
    {
        $prefix = self::NAMESPACE_PREFIX;
        $keys = $this->lists->xpath("//{$prefix}:node/{$prefix}:key");
        $keys = explode('|', implode('|', $keys));
        return $keys;
    }

    /**
     * @return SimpleXMLElement[]
     */
    public function getAllValue()
    {
        $prefix = self::NAMESPACE_PREFIX;
        return $this->lists->xpath("//{$prefix}:node/{$prefix}:value");
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function get($key)
    {
        $prefix = self::NAMESPACE_PREFIX;
        $value = $this->lists->xpath(
            "//{$prefix}:node[{$prefix}:key='{$key}']/{$prefix}:value"
        );
        if (!$value) {
            return false;
        }
        return (string)$value[0];
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function find($value
    ) {
        $prefix = self::NAMESPACE_PREFIX;
        $key = $this->lists->xpath(
            "//{$prefix}:node[{$prefix}:value='{$value}']/{$prefix}:key"
        );
        if (!$key) {
            return false;
        }
        return (string)$key[0];
    }
}