<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;

/**
 * Class HTTPRequest
 *
 * @package core\utils
 */
final class HTTPRequest
{

    const ROUTE_PARAM = 'route';
    private static $pagePath;
    private static $attributes = Array();

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public static function getAttribute($name)
    {
        if (array_key_exists($name, self::$attributes)) {
            return self::$attributes[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public static function setAttribute($name, $value)
    {
        self::$attributes[$name] = $value;
    }

    /**
     * @param string $name
     */
    public static function removeAttribute($name)
    {
        unset(self::$attributes[$name]);
    }

    /**
     * @return array
     */
    public static function getAttributes()
    {
        return self::$attributes;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getRequestParam($name)
    {
        if (array_key_exists($name, $_REQUEST)) {
            return $_REQUEST[$name];
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public static function setRequestParam($name, $value)
    {
        $_REQUEST[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function getParameter($name)
    {
        if (array_key_exists($name, $_GET)) {
            return $_GET[$name];
        }
        if (array_key_exists($name, $_POST)) {
            return $_POST[$name];
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return null
     */
    public static function getPostParam($name)
    {
        if (array_key_exists($name, $_POST)) {
            return $_POST[$name];
        }

        return null;
    }

    /**
     * @param $name
     *
     * @return null
     */
    public static function getGetParam($name)
    {
        if (array_key_exists($name, $_GET)) {
            return $_GET[$name];
        }

        return null;
    }

    /**
     * @return bool
     */
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * @return mixed
     */
    public static function getPostParams()
    {
        return $_POST;
    }

    /**
     * @return mixed
     */
    public static function getGetParams()
    {
        unset($_GET[self::ROUTE_PARAM]);
        return $_GET;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public static function setGetParam($name, $value)
    {
        $_GET[$name] = $value;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public static function setPostParam($name, $value)
    {
        $_POST[$name] = $value;
    }

    /**
     * @return array
     */
    public static function getParameters()
    {
        unset($_GET[self::ROUTE_PARAM]);
        return array_merge($_GET, $_POST);
    }

    /**
     *
     */
    public static function clearParameters()
    {
        $_GET = array();
        $_POST = array();
        $_FILES = array();
    }

    /**
     *
     */
    public static function clearPostParams()
    {
        $_POST = array();
        $_FILES = array();
    }

    public static function setRequestMethod($flag = true)
    {
        if ($flag) {
            $_SERVER['REQUEST_METHOD'] = 'GET';
        } else {
            $_SERVER['REQUEST_METHOD'] = 'POST';
        }
    }

    /**
     *
     */
    public static function clearGetParams()
    {
        $_GET = array();
    }

    /**
     * @param string $name
     *
     * @return null
     */
    public static function getFileParam($name)
    {
        if (!empty($_FILES[$name])
            && (is_array($_FILES[$name]['error'])
                || $_FILES[$name]['error'] == UPLOAD_ERR_OK)
        ) {
            return $_FILES[$name];
        }
        return null;
    }

    /**
     * @param string $name
     */
    public static function removeParameter($name)
    {
        if (empty($_GET[$name])) {
            return;
        }
        unset($_GET[$name]);
        if (empty($_POST[$name])) {
            return;
        }
        unset($_POST[$name]);
    }

    /**
     * @param string $name
     *
     * @return null
     */
    public static function getSession($name)
    {
        session_start();
        $returnValue = null;
        if (isset($_SESSION[AppInfo::$NAME][$name])) {
            $returnValue = $_SESSION[AppInfo::$NAME][$name];
            $returnValue = unserialize($returnValue);
        }
        session_commit();

        return $returnValue;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public static function setSession($name, $value)
    {
        $value = serialize($value);
        session_start();
        $_SESSION[AppInfo::$NAME][$name] = $value;
        session_commit();
    }

    /**
     * @param string $name
     */
    public static function removeSession($name)
    {
        session_start();
        unset($_SESSION[AppInfo::$NAME][$name]);
        session_commit();
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public static function getCookie($name)
    {
        $name = AppInfo::$NAME . ":" . $name;
        $returnValue = null;
        if (isset($_COOKIE[$name])) {
            $returnValue = $_COOKIE[$name];
            $returnValue = unserialize($returnValue);
        }

        return $returnValue;
    }

    /**
     * @param     $name
     * @param     $value
     * @param int $lifetime
     */
    public static function setCookie($name, $value, $lifetime = 900)
    {
        $name = AppInfo::$NAME . ":" . $name;
        $value = serialize($value);
        setcookie($name, $value, time() + $lifetime);
    }

    /**
     * @param $name
     */
    public static function removeCookie($name)
    {
        $name = AppInfo::$NAME . ":" . $name;
        unset($_COOKIE[$name]);
    }

    /**
     *
     */
    public static function destroySession()
    {
        session_start();
        unset($_SESSION[AppInfo::$NAME]);
        session_commit();
    }

    /**
     * @return string
     */
    public static function getRequestURI()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
        return '';
    }

    /**
     * @return string
     */
    public static function getFullAddress()
    {
        if (empty($_SERVER['HTTP_HOST']) || empty($_SERVER['REQUEST_URI'])) {
            return 'http://localhost';
        }
        return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || (!empty($_SERVER['SERVER_PORT'])
                && $_SERVER['SERVER_PORT'] == 443))
            ? "https://"
            : "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * @param string $pagePath
     */
    public static function setPagePath($pagePath)
    {
        $pagePath = trim($pagePath, '/');
        $pagePath = '/' . $pagePath;
        self::$pagePath = $pagePath;
    }

    /**
     * @return string
     */
    public static function getPagePath()
    {
        $path = self::$pagePath;
        if (empty($path) && !empty($_REQUEST[self::ROUTE_PARAM])) {
            $path = $_REQUEST[self::ROUTE_PARAM];
        }
        $path = trim($path, '/');
        $path = '/' . $path;
        return $path;
    }

    /**
     * @return mixed
     */
    public static function getServerContent()
    {
        return $_SERVER;
    }

    /**
     * @return string
     */
    public static function getRealPagePath()
    {
        $path = '';
        if (!empty($_REQUEST[self::ROUTE_PARAM])) {
            $path = $_REQUEST[self::ROUTE_PARAM];
        }
        $path = trim($path, '/');
        $path = '/' . $path;
        return $path;
    }

    /**
     * @return mixed
     */
    public static function getDomainName()
    {
        if (empty($_SERVER['HTTP_HOST'])) {
            return 'localhost';
        }
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mixed
     */
    public static function getReferrerURL()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return '';
        }
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * @return mixed
     */
    public static function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            if (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = '127.0.0.1';
            }
        }
        return $ip;
    }

    /**
     * @return bool
     */
    public static function isHTTPS()
    {
        return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
            || (!empty($_SERVER['SERVER_PORT'])
                && $_SERVER['SERVER_PORT'] == '443'));
    }

    /**
     * @param string $url
     * @param array  $option
     *
     * @return bool
     */
    public static function externalRequest($url, array $option = array()
    ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        foreach ($option as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $response = curl_exec($ch);

        if (curl_error($ch)) {
            return false;
        }
        $headerSize = 0;
        if (!empty($option[CURLOPT_HEADER]) && $option[CURLOPT_HEADER]) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        }
        curl_close($ch);

        $return = $response;
        if ($headerSize > 0) {
            $return = array();
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
            $return['header'] = $header;
            $return['headerSize'] = $headerSize;
            $return['body'] = $body;
        }

        return $return;
    }
}