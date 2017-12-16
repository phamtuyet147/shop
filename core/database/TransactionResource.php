<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 10/3/17
 * Time: 3:23 PM
 */

namespace core\database;


class TransactionResource extends ConnectDatabase
{
    /**
     * @var DatabaseQuery $DB_OBJECT
     */
    private $DB_OBJECT;

    /**
     * TransactionResource constructor.
     */
    public function __construct()
    {
        $sqlEngine = parent::getSQLEngine();
        $databaseConnection = parent::getConnect();
        switch ($sqlEngine) {
            case 'PDO':
                $this->DB_OBJECT = new PDOEngine();
                break;
            default:
                $this->DB_OBJECT = new MySQLiEngine();
                break;
        }
        $this->DB_OBJECT->initConnection($databaseConnection);
    }

    /**
     *
     */
    public function start()
    {
        $this->DB_OBJECT->startTransaction();
    }

    /**
     *
     */
    public function startReadOnly()
    {
        $this->DB_OBJECT->startReadOnlyTransaction();
    }

    /**
     *
     */
    public function commit()
    {
        $this->DB_OBJECT->commitTransaction();
    }

    /**
     *
     */
    public function rollback()
    {
        $this->DB_OBJECT->rollbackTransaction();
    }
}