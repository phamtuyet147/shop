<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 2:50 PM
 */

namespace core\utils;


final class HashUtil
{
    private static $PREFIX;
    private static $DEFAULT_HASH_METHOD;
    private static $CRYPT_COST = 10;

    /**
     * @param string $prefix
     * @param string $defaultHashMethod
     */
    public static function init($prefix, $defaultHashMethod)
    {
        self::$PREFIX = $prefix;
        self::$DEFAULT_HASH_METHOD = $defaultHashMethod;
    }

    /**
     * @param string $string
     * @param string $method
     *
     * @return string
     */
    public static function getHash($string, $method = null)
    {
        $string = self::$PREFIX . $string;
        if ($method === null) {
            $method = self::$DEFAULT_HASH_METHOD;
        }
        $returnString = $string;
        switch ($method) {
            case 'md5':
                $returnString = md5($string);
                break;
            case 'sha1':
                $returnString = sha1($string);
                break;
            case 'crypt':
                $returnString = self::createCryptHash($string);
                break;
        }
        return $returnString;
    }

    /**
     * @param string $string
     * @param string $hash
     * @param null   $method
     *
     * @return bool
     */
    public static function isEquals($string, $hash, $method = null)
    {
        if (empty($method)) {
            $method = self::$DEFAULT_HASH_METHOD;
        }
        if ($method != 'crypt') {
            $hashString = self::getHash($string);
            if ($hashString == $hash) {
                return true;
            }
            return false;
        }
        return hash_equals($hash, crypt($string, $hash));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private static function createCryptHash($string)
    {
        $salt = substr(base64_encode(openssl_random_pseudo_bytes(17)), 0, 22);
        $salt = str_replace("+", ".", $salt);
        $salt = '$' . implode(
                '$', Array(
                    "2y",
                    str_pad(self::$CRYPT_COST, 2, "0", STR_PAD_LEFT),
                    $salt
                )
            );
        $hash = crypt($string, $salt);
        return $hash;
    }

    /**
     * @return string
     */
    public static function generateId()
    {
        $result = uniqid('', true);
        return $result;
    }

    /**
     * @param null $method
     *
     * @return string
     */
    public static function randomHash($method = null)
    {
        $str = rand(0, 99999);
        $hash = self::getHash($str, $method);

        return $hash;
    }
}