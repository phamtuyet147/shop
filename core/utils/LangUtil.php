<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/16/17
 * Time: 8:44 AM
 */

namespace core\utils;


final class LangUtil
{
    private static $languageLocation;
    private static $DEFAULT_LANG = '';
    const LANG_FILE = 'lang';

    public static function init()
    {
        $request = new HTTPRequest();
        //Set locale
        $locale = $request->getSession('locale');
        if (empty($locale)) {
            $locale = self::$DEFAULT_LANG;
            $request->setSession('locale', $locale);
        }

        putenv("LANG={$locale}");
        setlocale(LC_MESSAGES, $locale);

        $domain = self::LANG_FILE;
        bindtextdomain($domain, self::$languageLocation);
        bind_textdomain_codeset($domain, "UTF-8");

        textdomain($domain);
    }

    /**
     * @param $key
     *
     * @return string
     */
    public static function getMessage($key)
    {
        if (function_exists('gettext')) {
            return gettext($key);
        }
        return $key;
    }

    /**
     * @param string $lang
     */
    public static function setDefaultLanguage($lang)
    {
        self::$DEFAULT_LANG = $lang;
    }

    /**
     * @return mixed
     */
    public static function getLanguageLocation()
    {
        return self::$languageLocation;
    }

    /**
     * @param mixed $languageLocation
     */
    public static function setLanguageLocation($languageLocation)
    {
        self::$languageLocation = $languageLocation;
    }
}