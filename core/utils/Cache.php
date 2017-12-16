<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 10/11/17
 * Time: 8:09 AM
 */

namespace core\utils;


use Memcache;
use Redis;

class Cache
{
    /**
     * @var Redis|Memcache $cache
     */
    private static $cache;
    private static $engine;

    /**
     * @param $engine
     */
    public static function init($engine)
    {
        switch ($engine) {
            case 'memcache':
                self::$cache = new Memcache();
                self::$engine = 'memcache';
                break;
            case 'redis':
                self::$cache = new Redis();
                self::$engine = 'redis';
                break;
        }
        self::$cache->connect('127.0.0.1');
    }

    /**
     *
     */
    public static function disconnect()
    {
        self::$cache = null;
        self::$engine = null;
    }

    /**
     * @param $name
     *
     * @return array|bool|string
     */
    public static function get($name)
    {
        $name = AppInfo::$NAME . ':' . $name;
        if (empty(self::$engine)) {
            return false;
        }
        return self::$cache->get($name);
    }

    /**
     * @param      $name
     * @param      $value
     * @param null $expire
     * @param null $flag
     */
    public static function set($name, $value, $expire = null, $flag = null)
    {
        $name = AppInfo::$NAME . ':' . $name;
        if (empty(self::$engine)) {
            return;
        }
        switch (self::$engine) {
            case 'memcache':
                self::$cache->set($name, $value, $flag, $expire);
                break;
            case 'redis':
                self::$cache->set($name, $value, $expire);
                break;
        }
    }

    /**
     * @param $name
     */
    public static function del($name)
    {
        $name = AppInfo::$NAME . ':' . $name;
        if (empty(self::$engine)) {
            return;
        }
        self::$cache->delete($name);
    }
}