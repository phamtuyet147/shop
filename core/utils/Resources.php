<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 10/11/17
 * Time: 10:54 AM
 */

namespace core\utils;


final class Resources
{
    const CACHE_RESOURCES = 'appResources';
    private static $resourcesLocation = null;
    private static $RESOURCES = array();

    /**
     * @param $resources
     */
    public static function init($resources)
    {
        if (!empty(self::$RESOURCES)) {
            return;
        }
        $resource = Cache::get(self::CACHE_RESOURCES);
        if ($resource) {
            self::$RESOURCES = json_decode($resource);
            return;
        }
        $resourcesDir = self::$resourcesLocation;
        if (empty($resourcesDir)) {
            return;
        }
        $resources = explode(',', $resources);
        foreach ($resources as $resource) {
            $resource = trim($resource);
            $resource = trim($resource, '/');
            $resource = $resourcesDir . DIRECTORY_SEPARATOR . $resource;
            $resource = FileUtils::readINIFile($resource);
            self::$RESOURCES = array_merge(self::$RESOURCES, $resource);
        }
        Cache::set(self::CACHE_RESOURCES, json_encode(self::$RESOURCES));
    }

    /**
     * @param $key
     *
     * @return null
     */
    public static function get($key)
    {
        if (isset(self::$RESOURCES->$key)) {
            return self::$RESOURCES->$key;
        }
        return null;
    }

    /**
     * @return null
     */
    public static function getResourcesLocation()
    {
        return self::$resourcesLocation;
    }

    /**
     * @param null $resourcesLocation
     */
    public static function setResourcesLocation($resourcesLocation)
    {
        self::$resourcesLocation = $resourcesLocation;
    }
}