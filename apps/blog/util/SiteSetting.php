<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/10/2017
 * Time: 10:48 AM
 */

namespace apps\blog\util;


use core\utils\Properties;

class SiteSetting
{
    const SETTING_FILE = 'setting.ini';

    /**
     * @var Properties $SETTINGS
     */
    private static $SETTINGS = null;

    /**
     *
     */
    public static function __init()
    {
        self::$SETTINGS = new Properties(self::SETTING_FILE);
    }

    /**
     * @param $key
     * @return null
     */
    public static function getSetting($key)
    {
        return self::$SETTINGS->get($key);
    }
}