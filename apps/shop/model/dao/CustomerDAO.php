<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 10:26 AM
 */

namespace apps\shop\model\dao;


use apps\shop\model\object\Customer;
use core\database\TransactionResource;
use core\utils\HashUtil;
use core\utils\SQLInstance;

class CustomerDAO
{
    const STATEMENT_FILE = 'customer.xml';
    /**
     * @var SQLInstance $STATEMENTS
     */
    private static $STATEMENTS;

    public static function __init()
    {
        self::$STATEMENTS = new SQLInstance(self::STATEMENT_FILE);
    }

    /**
     * @param $email
     * @param $phone
     *
     * @return Customer|bool
     */
    public static function getCustomerLoginInfoByPhoneOrEmail($email, $phone)
    {
        $stmt = self::$STATEMENTS->getPreparedStatement(
            'getCustomerLoginInfoByPhoneOrEmail'
        );
        $result = $stmt->execute(array($email, $phone));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        return new Customer($row['id_cus'], $row['phone'], $row['email']);
    }

    /**
     * @param $loginName
     * @param $password
     *
     * @return Customer|bool
     */
    public static function authenticateCustomer($loginName, $password)
    {
        $password = HashUtil::getHash($password);
        $stmt = self::$STATEMENTS->getPreparedStatement(
            'authenticateCustomer'
        );
        $result = $stmt->execute(array($loginName, $loginName, $password));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        return new Customer($row['id_cus'], $row['phone'], $row['email']);
    }

    /**
     * @param        $email
     * @param        $phone
     * @param        $password
     * @param        $name
     * @param        $address
     * @param string $gender
     */
    public static function createCustomer($email, $phone, $password, $name,
        $address, $gender = 'male'
    ) {
        $password = HashUtil::getHash($password);
        $transaction = new TransactionResource();
        $transaction->start();
        $stmt = self::$STATEMENTS->getPreparedStatement(
            'createCustomer'
        );
        $stmt->execute(array($name, $gender, $address));
        $customerId = $stmt->getLastInsertId();
        $stmt = self::$STATEMENTS->getPreparedStatement(
            'createCustomerLogin'
        );
        $stmt->execute(array($customerId, $phone, $email, $password));
        $transaction->commit();
    }

    /**
     * @param $customerId
     * @param $phone
     * @param $email
     *
     * @return Customer|bool
     */
    public static function getCustomerInfo($customerId, $phone, $email)
    {
        $stmt = self::$STATEMENTS->getPreparedStatement(
            'getCustomerInfo'
        );
        $result = $stmt->execute(array($customerId));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        return new Customer(
            $customerId, $phone, $email, $row['name'], $row['address'],
            $row['gender']
        );
    }
}