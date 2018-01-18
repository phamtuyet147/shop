<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 1/14/2018
 * Time: 10:31 PM
 */

namespace apps\shop\util;


use core\utils\Properties;

class ShopSetting
{
    const SETTING_FILE = 'shop_setting.ini';
    /**
     * @var Properties $SETTING
     */
    private static $SETTING;

    public static function __init()
    {
        self::$SETTING = new Properties(self::SETTING_FILE);
    }

    /**
     * @return mixed
     */
    public static function getProductsPerPage()
    {
        return self::$SETTING->get('limit.prod.per.page');
    }

    /**
     * @return mixed
     */
    public static function getCommentsPerPage()
    {
        return self::$SETTING->get('limit.comment.per.page');
    }

    /**
     * @return null
     */
    public static function getAllowedProductImageExt()
    {
        return self::$SETTING->get('product.image.ext');
    }

    /**
     * @return null
     */
    public static function getAllowedProductImageType()
    {
        return self::$SETTING->get('product.image.type');
    }

    /**
     * @return null
     */
    public static function getUploadDir()
    {
        return self::$SETTING->get('product.image.upload.dir');
    }
}