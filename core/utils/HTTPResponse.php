<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;

/**
 * Class HTTPResponse
 *
 * @package core\utils
 */
final class HTTPResponse
{

    /**
     * @param $url
     * @param bool $forgeDomain
     */
    public static function redirect($url, $forgeDomain = false)
    {
        if (!$forgeDomain) {
            $baseURL = AppInfo::$BASE_URL;
        } else {
            $baseURL = AppInfo::$APP_URL;
        }
        $baseURLPattern = preg_quote($baseURL, '/');
        $url = preg_replace('/^' . $baseURLPattern . '/', '', $url);
        $url = trim($url, '/');
        $url = '/' . $url;
        header("location: " . $baseURL . $url);
        exit;
    }

    /**
     * @return mixed
     */
    public static function getHeader()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @param $content
     */
    public static function setHeader($content)
    {
        header($content);
    }

    /**
     * @param $content
     */
    public static function setContent($content)
    {
        echo $content;
    }
}