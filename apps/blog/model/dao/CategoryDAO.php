<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:46 PM
 */

namespace apps\blog\model\dao;


use core\utils\SQLInstance;

class CategoryDAO
{
    const STATEMENT_FILE = 'category.xml';
    /**
     * @var SQLInstance $SQLInstance
     */
    private static $SQLInstance;

    public static function _init()
    {
        self::$SQLInstance = new SQLInstance(self::STATEMENT_FILE);
    }
}