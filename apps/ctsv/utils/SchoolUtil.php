<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/21/2017
 * Time: 9:55 PM
 */

namespace apps\ctsv\utils;


use apps\ctsv\object\School;
use core\database\PrepareStatement;
use core\utils\HashUtil;

class SchoolUtil extends AppUtil
{
    /**
     * @param string $userId
     *
     * @return School[]
     */
    public static function getSchoolInfoByUserId($userId)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getSchoolInfoByUserId'
        );
        $result = $prepared->execute(
            Array(
                $userId
            )
        );
        $schools = Array();
        while ($school = $result->fetch_object('apps\ctsv\object\School')) {
            $schools[] = $school;
        }
        return $schools;
    }

    /**
     * @param string $id
     *
     * @return School
     */
    public static function getSchoolById($id)
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement('getSchoolById');
        $result = $prepared->execute(
            Array(
                $id
            )
        );
        /** @var School $school */
        $school = null;
        if ($result->num_rows > 0) {
            $school = $result->fetch_object('apps\ctsv\object\School');
        }
        return $school;
    }

    /**
     * @return School[]
     */
    public static function getAllSchoolsInfo()
    {
        $prepared = self::$SQL_INSTANCES->getPreparedStatement(
            'getAllSchools'
        );
        $result = $prepared->execute();
        $schools = Array();
        while ($school = $result->fetch_object('apps\ctsv\object\School')) {
            $schools[] = $school;
        }
        return $schools;
    }

    /**
     * @param array $schools
     *
     * @return bool
     */
    public static function updateSchools($schools)
    {
        $insertSQL = self::$SQL_INSTANCES->getStatement('insertSchools');
        $insertData = Array();
        foreach ($schools as $index => $school) {
            if (empty($school['id']) && empty($school['name'])) {
                continue;
            }
            if (empty($school['name'])) {
                return false;
            }
            if (count($insertData) > 0) {
                $insertSQL .= ',';
            }
            if (empty($school['id'])) {
                $insertData[] = HashUtil::generateId();
            } else {
                $insertData[] = $school['id'];
            }
            $insertData[] = $school['name'];
            $insertSQL .= '(?,?)';
        }
        if (!empty($insertData)) {
            $prepared = self::$SQL_INSTANCES->getPreparedStatement(
                'deleteAllSchools'
            );
            $prepared->execute();

            $prepared = new PrepareStatement($insertSQL);
            $prepared->execute($insertData);
        }
        return true;
    }
}