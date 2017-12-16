<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\database;

use Exception;
use mysqli_result;
use PDOStatement;

class PrepareStatement extends ConnectDatabase
{

    /**
     * @var DatabaseQuery $DB_OBJECT
     */
    private $DB_OBJECT;

    /**
     * @param string $query
     */
    public function __construct($query)
    {
        $sqlEngine          = parent::getSQLEngine();
        $databaseConnection = parent::getConnect();
        switch ($sqlEngine) {
            case 'PDO':
                $this->DB_OBJECT = new PDOEngine($query);
                break;
            default:
                $this->DB_OBJECT = new MySQLiEngine($query);
                break;
        }
        $this->DB_OBJECT->initConnection($databaseConnection);
    }

    /**
     * @param null $data
     *
     * @return bool|mysqli_result|PDOStatement
     */
    public function execute($data = null)
    {
        try {
            $result = $this->DB_OBJECT->execute($data);

            return $result;
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getLastInsertId()
    {
        try {
            $result = $this->DB_OBJECT->getLastInsertId();

            return $result;
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}