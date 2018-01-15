<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 7:55 PM
 */

namespace apps\shop\model\dao;


use apps\shop\model\object\Category;
use core\utils\SQLInstance;

class CategoryDAO
{
    const STATEMENT_FILE = 'category.xml';
    /**
     * @var SQLInstance $STATEMENTS
     */
    private static $STATEMENTS;

    /**
     *
     */
    public static function __init()
    {
        self::$STATEMENTS = new SQLInstance(self::STATEMENT_FILE);
    }

    /**
     * @return Category[]
     */
    public static function getTopCategories()
    {
        $prepare = self::$STATEMENTS->getPreparedStatement('getTopCategories');
        $result = $prepare->execute();

        $categories = array();
        while ($row = $result->fetch_assoc()) {
            $categories[] = new Category(
                $row['id'], $row['title'], $row['url'], $row['short_tag'],
                $row['id_parent']
            );
        }

        return $categories;
    }

    /**
     * @param $shortTag
     *
     * @return Category|bool
     */
    public static function getCategoryByShortTag($shortTag)
    {
        $prepare = self::$STATEMENTS->getPreparedStatement(
            'getCategoryByShortTag'
        );
        $result = $prepare->execute(array($shortTag));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        return new Category(
            $row['id'], $row['title'], $row['url'], $row['short_tag'],
            $row['id_parent']
        );
    }
}