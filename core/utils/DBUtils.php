<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;

use core\database\ConnectDatabase;
use core\database\PrepareStatement;
use PDOStatement;

/**
 * Class DBUtils
 *
 * @package core\utils
 */
final class DBUtils extends ConnectDatabase
{

    public static function datetime($string)
    {
        return DateUtil::parseDateTime($string, 'Y-m-d H:i:s');
    }

    public static function date($string)
    {
        return DateUtil::parseDate($string, 'Y-m-d');
    }

    public static function boolean($value)
    {
        return (StringUtils::toBoolean($value)) ? 1 : 0;
    }

    /**
     * @param string $query
     *
     * @return PrepareStatement
     */
    public static function prepare($query)
    {
        $prepareStatement = new PrepareStatement($query);

        return $prepareStatement;
    }

    /**
     * @param string     $query
     * @param array|null $data
     *
     * @return bool|\mysqli_result|PDOStatement
     */
    public static function executeQuery($query, array $data = null)
    {
        $prepareStatement = new PrepareStatement($query);
        $result           = $prepareStatement->execute($data);

        return $result;
    }

    public static function initSQLInstance($sqlFile)
    {
        $sqlInstance = new SQLInstance($sqlFile);
        return $sqlInstance;
    }
}