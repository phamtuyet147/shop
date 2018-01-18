<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/15/2018
 * Time: 6:48 AM
 */

namespace apps\shop\model\dao;


use apps\shop\model\object\Product;
use apps\shop\util\ShopSetting;
use core\utils\DateUtil;
use core\utils\DBUtils;
use core\utils\SQLInstance;
use core\utils\StringUtils;

class ProductDAO
{
    const STATEMENT_FILE = 'product.xml';
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
     * @param array $options
     *
     * @return array
     */
    public static function getProductsByConditions($options = array()
    ) {
        $statement = self::$STATEMENTS->getStatement('getProductsByConditions');
        $conditions = array(
            'statement' => array(),
            'data'      => array()
        );

        //Check query conditions
        if (!empty($options['id_category'])) {
            $conditions['statement'][]
                = "id_category = ?";
            $conditions['data'][] = $options['id_category'];
        }
        if (!empty($options['keyword'])) {
            $conditions['statement'][] = "title LIKE ? OR short_tag LIKE ?";
            $keyword = $options['keyword'];
            $shortTag = StringUtils::convertStringToURL($keyword);
            $shortTag = str_replace('-', '%', $shortTag);
            $conditions['data'][] = "%{$keyword}%";
            $conditions['data'][] = "%$shortTag%";
        }
        if (!empty($options['price_min'])) {
            $conditions['statement'][] = "price >= ?";
            $conditions['data'][] = $options['price_min'];
        }
        if (!empty($options['price_max'])) {
            $conditions['statement'][] = "price <= ?";
            $conditions['data'][] = $options['price_max'];
        }
        $conditions['statement'] = implode(' AND ', $conditions['statement']);
        if (empty($conditions['statement'])) {
            $conditions['statement'] = '1 = 1';
        }

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

    /**
     * @param $categoryid
     * @param $title
     * @param $price
     * @param $shortTag
     * @param $shortDesc
     * @param $desc
     * @param $thumbnail
     *
     * @return bool|\mysqli_result|\PDOStatement
     */
    public static function createProduct($categoryid, $title, $shortTag, $price,
        $shortDesc, $desc, $thumbnail
    ) {
        $now = DateUtil::getCurrentDateTime();
        $stmt = self::$STATEMENTS->getPreparedStatement('createProduct');
        $result = $stmt->execute(
            array($categoryid, $title, $shortTag, $price, $shortDesc, $desc,
                  $thumbnail, $now, $now)
        );

        return $result;
    }

    /**
     * @param $shortTag
     *
     * @return Product|bool
     */
    public static function getProductByShortTag($shortTag)
    {
        $stmt = self::$STATEMENTS->getPreparedStatement('getProductByShortTag');
        $result = $stmt->execute(array($shortTag));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        return new Product(
            $row['id'], $row['id_category'], $row['title'],
            $row['short_tag'], $row['price'], $row['short_desc'],
            $row['desc'], $row['thumbnail'], $row['dt_create'],
            $row['dt_modified']
        );
    }

    public static function getProductsInList($IDs)
    {
        $stmt = self::$STATEMENTS->getStatement('getProductsInList');
        $stmt = str_replace(':list', implode(',', $IDs), $stmt);

        $result = DBUtils::executeQuery($stmt);
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