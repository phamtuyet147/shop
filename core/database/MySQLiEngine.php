<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/15/17
 * Time: 10:55 AM
 */

namespace core\database;


use Exception;
use mysqli;
use mysqli_result;

class MySQLiEngine implements DatabaseQuery
{
    /**
     * @var string $QUERY
     * @var string $DATA_TYPE
     * @var array  $DATA
     */
    private $QUERY, $DATA_TYPE, $DATA;
    /**
     * @var mysqli $CONNECTION
     */
    private $CONNECTION;

    /**
     * @param string $query
     */
    public function __construct($query = '')
    {
        $this->QUERY = $query;
    }

    /**
     * @param mysqli $connection
     */
    public function initConnection($connection)
    {
        $this->CONNECTION = $connection;
    }

    /**
     * @param array $data
     */
    public function bindData(array $data)
    {
        $params          = Array();
        $types           = array_reduce(
            $data, function ($string, &$arg) use (&$params) {
            $params[] = &$arg;
            if (is_float($arg)) {
                $string .= 'd';
            } elseif (is_integer($arg)) {
                $string .= 'i';
            } elseif (is_string($arg)) {
                $string .= 's';
            } else {
                $string .= 'b';
            }

            return $string;
        }, ''
        );
        $this->DATA      = $params;
        $this->DATA_TYPE = $types;
    }

    /**
     * @param array|null $data
     *
     * @return mysqli_result
     */
    public function execute($data = null)
    {
        if (!empty($data)) {
            $this->bindData($data);
        }
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

            if (!empty($this->DATA)) {
                array_unshift($this->DATA, $this->DATA_TYPE);
                call_user_func_array(
                    Array($prepareStatement, 'bind_param'),
                    $this->refValues($this->DATA)
                );
            }

            $result = $prepareStatement->execute();
            if ($result) {
                if (method_exists($prepareStatement, 'get_result')) {
                    $result = $prepareStatement->get_result();
                } else {
                    throw new Exception(
                        'Your version of mysql doesn\'t supported, pleae contact administrator for more information'
                    );
                }
            }

            return $result;
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
        return $this->CONNECTION->insert_id;
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    private function refValues(Array $arr)
    {
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = Array();
            foreach ($arr as $key => $value) {
                $refs[$key] = &$arr[$key];
            }
            return $refs;
        }
        return $arr;
    }

    /**
     *
     */
    public function startTransaction()
    {
        $this->CONNECTION->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    }

    /**
     *
     */
    public function startReadOnlyTransaction()
    {
        $this->CONNECTION->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
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
        $this->CONNECTION->rollback();
    }
}