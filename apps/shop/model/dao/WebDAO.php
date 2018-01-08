<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 7:52 PM
 */

namespace apps\shop\model\dao;


use core\utils\SQLInstance;

class WebDAO
{
    const STATEMENT_FILE = 'web.xml';

    /**
     * @var SQLInstance $STATEMENTS
     */
    protected static $STATEMENTS;

    /**
     *
     */
    public static function __init()
    {
        self::$STATEMENTS = new SQLInstance(static::STATEMENT_FILE);
    }
}