<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 10/18/17
 * Time: 9:36 AM
 */

namespace core\utils;


class Properties
{
    private static $propertiesLocation;
    private $properties;

    /**
     * Properties constructor.
     *
     * @param string $propertyFile
     */
    public function __construct($propertyFile)
    {
        $properties = Cache::get("prop:{$propertyFile}");
        if (!$properties) {
            $filePath = self::$propertiesLocation . DIRECTORY_SEPARATOR
                . $propertyFile;
            $properties = FileUtils::readINIFile($filePath);
            Cache::set("prop:{$propertyFile}", json_encode($properties));
        } else {
            $properties = json_decode($properties, true);
        }

        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public static function getPropertiesLocation()
    {
        return self::$propertiesLocation;
    }

    /**
     * @param mixed $propertiesLocation
     */
    public static function setPropertiesLocation($propertiesLocation)
    {
        self::$propertiesLocation = $propertiesLocation;
    }

    /**
     * @param string $key
     *
     * @return null
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        }

        return null;
    }
}