<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/10/2017
 * Time: 10:41 PM
 */

namespace apps\blog\model\dao;


use apps\blog\model\object\Label;
use core\utils\SQLInstance;

class LabelDAO
{
    const SQL_STATEMENT = 'label.xml';
    /**
     * @var SQLInstance $SQLInstance
     */
    private static $SQLInstance;

    /**
     *
     */
    public static function __init()
    {
        self::$SQLInstance = new SQLInstance(self::SQL_STATEMENT);
    }

    /**
     *
     */
    public static function getAllLabels()
    {
        $prepare = self::$SQLInstance->getPreparedStatement('getAllLabels');
        $result = $prepare->execute();

        $labels = array();
        while ($row = $result->fetch_assoc()) {
            $labels[] = new Label($row['cd_tag'], $row['title']);
        }

        return $labels;
    }

    /**
     * @param $articleId
     *
     * @return array
     */
    public static function getArticleLabels($articleId)
    {
        $prepare = self::$SQLInstance->getPreparedStatement('getArticleLabels');
        $result = $prepare->execute(array($articleId));

        $labels = array();
        while ($row = $result->fetch_assoc()) {
            $labels[] = new Label($row['cd_tag'], $row['title']);
        }

        return $labels;
    }

    /**
     * @param $tagName
     *
     * @return Label|bool
     */
    public static function getLabelByTagName($tagName)
    {
        $prepare = self::$SQLInstance->getPreparedStatement(
            'getLabelByTagName'
        );
        $result = $prepare->execute(array($tagName));

        $row = $result->fetch_assoc();
        if (!$row) {
            return false;
        }

        $label = new Label($row['cd_tag'], $row['title']);
        return $label;
    }

    /**
     * @param $tagName
     * @param $title
     *
     * @return bool
     */
    public static function createLabel($tagName, $title)
    {
        $prepare = self::$SQLInstance->getPreparedStatement(
            'createLabel'
        );
        $prepare->execute(array($tagName, $title));

        return true;
    }
}