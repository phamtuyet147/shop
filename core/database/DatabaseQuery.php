<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/15/17
 * Time: 10:52 AM
 */

namespace core\database;


use mysqli_result;
use PDOStatement;

interface DatabaseQuery
{
    /**
     * @param $connection
     *
     */
    public function initConnection($connection);

    /**
     * @param null|array $data
     *
     * @return mysqli_result|PDOStatement
     */
    public function execute($data = null);

    /**
     *
     * @return string
     */
    public function getLastInsertId();

    /**
     *
     */
    public function startTransaction();

    /**
     *
     */
    public function startReadOnlyTransaction();

    /**
     *
     */
    public function commitTransaction();

    /**
     *
     */
    public function rollbackTransaction();
}