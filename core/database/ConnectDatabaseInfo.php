<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/8/2017
 * Time: 7:56 PM
 */

namespace core\database;

use core\utils\HashUtil;

/**
 * Class ConnectDatabaseInfo
 *
 * @package core\database
 */
abstract class ConnectDatabaseInfo
{

    /**
     * @var string $HOST_NAME
     * @var string $PORT
     * @var string $DATABASE_NAME
     * @var string $USERNAME
     * @var string $HOST_NAME
     */
    private static $HOST_NAME = '';
    private static $PORT = '';
    private static $DATABASE_NAME = '';
    private static $USERNAME = '';
    private static $PASSWORD = '';
    private static $SQL_ENGINE = 'mysqli';

    /**
     * @param string $hostName
     * @param string $port
     * @param string $databaseName
     * @param string $username
     * @param string $password
     * @param string $hashType
     * @param string $sqlEngine
     */
    public final static function initConnection($hostName, $port, $databaseName,
        $username, $password, $hashType, $sqlEngine = null
    ) {
        self::$HOST_NAME     = $hostName;
        self::$PORT          = $port;
        self::$DATABASE_NAME = $databaseName;
        self::$USERNAME      = $username;
        self::$PASSWORD      = HashUtil::getHash($password, $hashType);
        if (!empty($sqlEngine)) {
            self::$SQL_ENGINE = $sqlEngine;
        }
    }

    /**
     * @return string
     */
    public static function getSQLEngine()
    {
        return self::$SQL_ENGINE;
    }

    /**
     * @param string $sqlEngine
     */
    public static function setSQLEngine($sqlEngine)
    {
        self::$SQL_ENGINE = $sqlEngine;
    }

    /**
     * @return string
     */
    protected final static function getHostName()
    {
        return self::$HOST_NAME;
    }

    /**
     * @return string
     */
    protected final static function getPort()
    {
        return (int)self::$PORT;
    }

    /**
     * @return string
     */
    protected final static function getDatabaseName()
    {
        return self::$DATABASE_NAME;
    }

    /**
     * @return string
     */
    protected final static function getDatabaseUserName()
    {
        return self::$USERNAME;
    }

    /**
     * @return string
     */
    protected final static function getDatabasePassword()
    {
        return self::$PASSWORD;
    }
}