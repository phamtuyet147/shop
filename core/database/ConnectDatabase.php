<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/8/2017
 * Time: 7:56 PM
 */

namespace core\database;

use Exception;
use mysqli;
use PDO;
use PDOException;

/**
 * Class ConnectDatabase
 *
 * @package core\database
 */
abstract class ConnectDatabase extends ConnectDatabaseInfo
{

    /**
     * @var MySQLi|PDO $connectInfo
     */
    private static $connectInfo = null;

    /**
     * @return mysqli|PDO
     */
    protected final static function getConnect()
    {
        if (empty(self::$connectInfo)) {
            self::$connectInfo = self::ConnectMySQL();
        }

        return self::$connectInfo;
    }

    /**
     * @return mysqli|PDO
     */
    private final static function ConnectMySQL()
    {
        try {
            $connect = null;
            switch (parent::getSQLEngine()) {
                case 'PDO':
                    $connect = new PDO(
                        'mysql:host=' . parent::getHostName() . ';port='
                        . parent::getPort()
                        . ';dbname=' . parent::getDatabaseName(),
                        parent::getDatabaseUserName(),
                        parent::getDatabasePassword(),
                        Array(
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\'',
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
                        )
                    );
                    break;
                default:
                    $connect
                        = new MySQLi(
                        parent::getHostname(), parent::getDatabaseUsername(),
                        parent::getDatabasePassword(),
                        parent::getDatabaseName(),
                        parent::getPort()
                    );
                    if ($connect->errno) {
                        throw new Exception(
                            'Caught Exception: Could not connect to MySQL'
                        );
                    }
                    $connect->set_charset("utf8");
                    break;
            }

            return $connect;
        } catch (PDOException $e) {
            exit('Caught Exception: ' . $e->getMessage());
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}
