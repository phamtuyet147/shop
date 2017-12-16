<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/19/2017
 * Time: 9:41 PM
 */

namespace apps\ctsv\utils;


use core\utils\SQLInstance;

class AppUtil
{
    /**
     * @var SQLInstance $SQL_INSTANCES
     */
    protected static $SQL_INSTANCES;

    public static function init()
    {
        static::$SQL_INSTANCES = new SQLInstance('ctsv.sqli');
    }
}