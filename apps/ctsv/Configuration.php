<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/8/2017
 * Time: 7:56 PM
 */

namespace apps\ctsv;


use core\processor\AppConfiguration;

final class Configuration extends AppConfiguration
{
    private static $SUPER_USER_ID = '1228569565597317d4176d3';
    protected static $DEFAULT_LANGUAGE = 'vi-VN';
    protected static $HASH
        = Array(
            'prefix'          => 'ctsv',
            'defaultHashType' => 'md5'
        );
    protected static $CONNECTION
        = Array(
            'hostname'     => 'localhost',
            'databaseName' => 'ctsv',
            'username'     => 'ctsv',
            'password'     => '123456',
            'hashType'     => 'md5'
        );
    protected static $DIRECTORY
        = Array(
            'resources'  => 'resources',
            'properties' => 'properties',
            'language'   => 'resources/lang',
            'sql'        => 'resources/sql'
        );

    public static function isAdmin($userId)
    {
        if ($userId == self::$SUPER_USER_ID) {
            return true;
        }
        return false;
    }
}