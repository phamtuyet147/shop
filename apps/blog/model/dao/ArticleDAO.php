<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 11/5/2017
 * Time: 4:46 PM
 */

namespace apps\blog\model\dao;


use apps\blog\model\object\Article;
use apps\blog\model\object\Author;
use apps\blog\util\SiteSetting;
use core\utils\DBUtils;
use core\utils\SQLInstance;

class ArticleDAO
{
    const SQL_STATEMENT = 'article.xml';
    /**
     * @var SQLInstance $SQLInstance
     */
    private static $SQLInstance;

    public static function __init()
    {
        self::$SQLInstance = new SQLInstance(self::SQL_STATEMENT);
    }

    /**
     * @param int $from
     * @param int $limit
     *
     * @return array
     */
    public static function getArticles($from = 0, $limit = 0)
    {
        $sql = self::$SQLInstance->getStatement('getAllArticles');
        if (empty($limit)) {
            $limit = SiteSetting::getSetting('admin.articles.rpp');
        }
        $sql = str_replace(':from', $from, $sql);
        $sql = str_replace(':limit', $limit, $sql);
        $result = DBUtils::executeQuery($sql);

        $articles = array();
        while ($row = $result->fetch_assoc()) {
            $articles[] = new Article(
                $row['id'], $row['title'], $row['content'],
                new Author($row['author']), $row['dt_created'],
                $row['dt_modified'], $row['short_url'],
                $row['status']
            );
        }
        return $articles;
    }
}