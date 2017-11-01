<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/8/2017
 * Time: 7:56 PM
 */

namespace apps\acm;


use core\processor\AppConfiguration;

final class Configuration extends AppConfiguration
{
    protected static $DEFAULT_LANGUAGE = 'vi-VN';
    protected static $HASH
        = Array(
            'prefix'          => 'uitacm',
            'defaultHashType' => 'md5'
        );
    protected static $CONNECTION
        = Array(
            'hostname'     => 'localhost',
            'databaseName' => 'uitacm',
            'username'     => 'uitacm',
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
}