<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/15/17
 * Time: 11:04 AM
 */

namespace core\database;


use Exception;
use PDO;
use PDOException;
use PDOStatement;

class PDOEngine implements DatabaseQuery
{
    private $QUERY;
    /**
     * @var PDO $CONNECTION
     */
    private $CONNECTION;

    public function __construct($query = '')
    {
        $this->QUERY = $query;
    }

    /**
     * @param PDO $connection
     */
    public function initConnection($connection)
    {
        $this->CONNECTION = $connection;
    }

    /**
     * @param array|null $data
     *
     * @return PDOStatement
     */
    public function execute($data = null)
    {
        try {
            if (empty($this->QUERY)) {
                throw new Exception('Query is empty');
            }
            $prepareStatement = $this->CONNECTION->prepare($this->QUERY);
            if (!$prepareStatement) {
                throw new Exception(
                    'Error occur when execute query ' . $this->QUERY
                );
            }

            $prepareStatement->execute($data);
            return $prepareStatement;
        } catch (PDOException $e) {
            exit('Caught Exception: ' . $e->getMessage());
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     *
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->CONNECTION->lastInsertId();
    }

    /**
     *
     */
    public function startTransaction()
    {
        $this->CONNECTION->beginTransaction();
    }

    /**
     *
     */
    public function startReadOnlyTransaction()
    {
        $this->CONNECTION->beginTransaction();
    }

    /**
     *
     */
    public function commitTransaction()
    {
        $this->CONNECTION->commit();
    }

    /**
     *
     */
    public function rollbackTransaction()
    {
        $this->CONNECTION->commit();
    }
}