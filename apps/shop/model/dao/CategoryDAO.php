<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 7:55 PM
 */

namespace apps\shop\model\dao;


use apps\shop\model\object\Category;

class CategoryDAO extends WebDAO
{
    const STATEMENT_FILE = 'category.xml';

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
                $row['id'], $row['title'], $row['short_tag'], $row['id_parent']
            );
        }

        return $categories;
    }

    public static function getAllCategories()
    {

    }
}