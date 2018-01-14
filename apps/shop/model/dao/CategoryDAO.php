<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/7/2018
 * Time: 7:55 PM
 */

namespace apps\shop\model\dao;


use apps\shop\model\object\Category;
use apps\shop\model\object\Product;
use apps\shop\util\ShopSetting;
use core\utils\DBUtils;

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

    /**
     * @param       $categoryId
     * @param array $options
     *
     * @return array
     */
    public static function getProductsByCategoryId($categoryId,
        $options = array()
    ) {
        $statement = self::$STATEMENTS->getStatement('getProductsByCategoryId');
        $conditions = array(
            'statement' => array('id_category = ?'),
            'data'      => array($categoryId)
        );

        //Check query conditions
        if (!empty($options['keyword'])) {
            $conditions['statement'][] = "title LIKE '%{$options['keyword']}%'";
            $conditions['data'][] = $options['keyword'];
        }
        if (!empty($options['price_min'])) {
            $conditions['statement'][] = "price >= {$options['price_min']}";
            $conditions['data'][] = $options['price_min'];
        }
        if (!empty($options['price_max'])) {
            $conditions['statement'][] = "price <= {$options['price_max']}";
            $conditions['data'][] = $options['price_max'];
        }
        $conditions['statement'] = implode(' AND ', $conditions['statement']);

        //Check order priority
        $order = 'dt_modified DESC, id DESC, price';
        if (!empty($options['order'])) {
            switch ($options['order']) {
                case 'price_asc':
                    $order = 'price, dt_modified DESC, id DESC';
                    break;
                case 'price_desc':
                    $order = 'price DESC, dt_modified DESC, id DESC';
                    break;
                case 'newest_last':
                    $order = 'dt_modified, id, price';
                    break;
            }
        }

        //Check limit per page
        $from = 0;
        $limit = ShopSetting::getProductsPerPage();
        if (!empty($options['from'])) {
            $from = $options['from'];
        }
        if (!empty($options['limit'])) {
            $limit = $options['limit'];
        }

        $statement = str_replace(
            ':condition', $conditions['statement'], $statement
        );
        $statement = str_replace(
            ':order', $order, $statement
        );
        $statement = str_replace(
            ':from', $from, $statement
        );
        $statement = str_replace(
            ':limit', $limit, $statement
        );

        $result = DBUtils::executeQuery($statement, $conditions['data']);
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product(
                $row['id'], $row['id_category'], $row['title'],
                $row['short_tag'], $row['price'], $row['short_desc'],
                $row['desc'], $row['thumbnail'], $row['dt_create'],
                $row['dt_modified']
            );
        }

        return $products;
    }
}