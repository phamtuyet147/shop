<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;


use core\database\PrepareStatement;
use Exception;

/**
 * Class SQLInstance
 *
 * @package core\utils
 */
class SQLInstance
{
    const CACHE_PREFIX_SQL_RESOURCE = 'sqlResource:';
    const CACHE_PREFIX_SQL_STATEMENT = 'sql:';
    private static $sqlLocation;
    private $sqlFile;
    private $SQL_RESOURCES;

    /**
     * @return mixed
     */
    public static function getSqlLocation()
    {
        return self::$sqlLocation;
    }

    /**
     * @param mixed $sqlLocation
     */
    public static function setSqlLocation($sqlLocation)
    {
        self::$sqlLocation = $sqlLocation;
    }

    /**
     *
     */
    public function initSQL()
    {
        if (!empty($this->SQL_RESOURCES)) {
            return;
        }
        $cacheKey = self::CACHE_PREFIX_SQL_RESOURCE . $this->sqlFile;
        $filePath = self::$sqlLocation . DIRECTORY_SEPARATOR
            . $this->sqlFile;
        $resources = Cache::get($cacheKey);
        if (!$resources) {
            $this->SQL_RESOURCES = FileUtils::readXMLFile($filePath);
            Cache::set($cacheKey, $this->SQL_RESOURCES->asXML());
        } else {
            $this->SQL_RESOURCES = simplexml_load_string($resources);
        }
    }

    /**
     * SQLInstance constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->sqlFile = $fileName;
    }

    /**
     * @param $key
     *
     * @return array|bool|string
     */
    public function getStatement($key)
    {
        try {
            $cacheKey = self::CACHE_PREFIX_SQL_STATEMENT . $this->sqlFile
                . ":{$key}";
            $statement = Cache::get($cacheKey);
            if ($statement) {
                return $statement;
            }
            if (empty($this->SQL_RESOURCES)) {
                $this->initSQL();
            }
            if (empty($this->SQL_RESOURCES->$key)) {
                throw new Exception(
                    'Miss SQL statement definition in resources: ' . $key
                );
            }
            $statement = $this->SQL_RESOURCES->$key;
            Cache::set($cacheKey, $statement);
            return $statement;
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     * @param $key
     *
     * @return PrepareStatement
     */
    public function getPreparedStatement($key)
    {
        try {
            $query = (string)self::getStatement($key);
            $prepareStatement = new PrepareStatement($query);

            return $prepareStatement;
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}