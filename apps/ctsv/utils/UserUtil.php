<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/19/2017
 * Time: 9:32 PM
 */

namespace apps\ctsv\utils;


use apps\ctsv\object\User;
use core\database\PrepareStatement;
use core\utils\HashUtil;

class UserUtil extends AppUtil
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return User
     */
    public static function getUserInfo($username, $password)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getUserLogin');
        $result = $prepared->execute(
            Array(
                $username,
                $password
            )
        );
        /** @var User $user */
        $user = null;
        if ($result->num_rows > 0) {
            $user = $result->fetch_object('apps\ctsv\object\User');
        }
        return $user;
    }

    /**
     * @param string $id
     *
     * @return User|null
     */
    public static function getUserById($id)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getUserById');
        $result = $prepared->execute(
            Array(
                $id
            )
        );
        /** @var User $user */
        $user = null;
        if ($result->num_rows > 0) {
            $user = $result->fetch_object('apps\ctsv\object\User');
        }
        return $user;
    }

    /**
     * @param string $userId
     * @param string $password
     *
     * @return bool
     */
    public static function updateUserPassword($userId, $password)
    {
        $password = HashUtil::getHash($password);
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'updateUserPassword'
        );
        $prepared->execute(Array($password, $userId));
        return true;
    }

    /**
     * @return User[]
     */
    public static function getUsers()
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getUsers');
        $result = $prepared->execute();
        $users = Array();
        while ($user = $result->fetch_object('apps\ctsv\object\User')) {
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param string $username
     * @param string $password
     */
    public static function createUser($username, $password, $schools)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'insertUser'
        );
        $userId = HashUtil::generateId();
        $password = HashUtil::getHash($password);
        $prepared->execute(Array($userId, $username, $password));
        self::updateSchools($userId, $schools);
    }

    public static function updateSchools($userId, $schools)
    {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertUserSchools');
        $insertData = Array();
        $index = 0;
        foreach ($schools as $schoolId) {
            $index++;
            if (count($insertData) > 0) {
                $insertSQL .= ',';
            }
            $insertData[] = $userId;
            $insertData[] = $schoolId;
            $insertSQL .= '(?,?)';
        }
        if (!empty($insertData)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'deleteUserSchoolsByUserId'
            );
            $prepared->execute(Array($userId));

            $prepared = new PrepareStatement($insertSQL);
            $prepared->execute($insertData);
        }
    }
}