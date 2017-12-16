<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 3:44 PM
 */

namespace core\processor;


use core\app\AppFilter;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use Exception;

final class Filters
{
    private static $filters = Array();
    private static $index = 0;
    private static $completed = true;

    /**
     * Filters constructor.
     *
     * @param array $filters
     */
    public function __construct($filters)
    {
        self::$filters = $filters;
        self::$index   = 0;
        if (count(self::$filters) > 0) {
            self::$completed = false;
        }
    }

    /**
     *
     */
    public function nextFilter()
    {
        try {
            if (self::$index < count(self::$filters)) {
                $filterClass = self::$filters[self::$index];
                /** @var AppFilter $filter */
                if (!class_exists($filterClass)) {
                    throw new Exception(
                        'Could not find filter'
                    );
                }
                $filter = new $filterClass();
                self::$index++;
                $filter->doFilter(new HTTPRequest(), new HTTPResponse(), $this);
            } else {
                self::$completed = true;
            }
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    public function isCompleted()
    {
        return self::$completed;
    }
}