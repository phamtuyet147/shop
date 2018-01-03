<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 4:17 PM
 */

namespace core\processor;


use core\utils\AppInfo;
use core\utils\Cache;
use core\utils\FileUtils;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\StringUtils;
use Exception;

final class AppsInitialize
{
    const NAMESPACE_PREFIX = 'st';
    const SITE_SETTING = 'w_setting.xml';
    const CACHE_W_INIT = 'wInit';

    private static $APP;

    /**
     *
     */
    public static function __init()
    {
        try {
            self::initWApp();
            $app = self::$APP;

            if (empty($app->appName) || empty($app->domainName)
                || empty($app->ssl)
                || empty($app->appSetting)
                || empty($app->appMapping)
                || empty($app->appView)
            ) {
                throw new Exception('W-Initialize file is in wrong format');
            }

            self::storeAppToCache();
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function initApp()
    {

        /**
         * Init basic application information:
         * - Name
         * - Base URL
         * - Base absolute path
         * - Check app SSL
         * - Init App Setting
         * - Init App Routing
         * - Init App View
         * - Init App Validation (if presented)
         */
        $app = self::$APP;

        $appName = (string)$app->appName;

        $absoluteAppLocation = W_APPS . DIRECTORY_SEPARATOR . $appName;

        AppInfo::$NAME = $appName;
        AppInfo::$BASE_PATH = $absoluteAppLocation;

        //Check app SSL
        $reqSSL = HTTPRequest::isHTTPS();
        $ssl = StringUtils::toBoolean((string)self::$APP->ssl);
        $httpProtocol = $ssl ? 'https://' : 'http://';
        $reqProtocol = $reqSSL ? 'https://' : 'http://';

        AppInfo::$REQ_URL = $reqProtocol . AppInfo::$REQ_DOMAIN;
        AppInfo::$BASE_URL = $httpProtocol . (string)$app->domainName;

        //Check ssl constraint for app
        if (!empty($app->forceSSL)
            && StringUtils::toBoolean(self::$APP->forceSSL)
            && !$reqSSL
        ) {
            $requestURI = HTTPRequest::getRequestURI();
            HTTPResponse::redirect($requestURI);
        }

        //Init App Setting
        $appConfig = (string)$app->appSetting;

        //Init App Routing
        $appMapping = (string)$app->appMapping;

        //Init App Views
        $appView = (string)$app->appView;


        AppConfiguration::init($appConfig);

        AppRouting::init($appMapping);

        ViewConfig::init($appView);

        if (!empty($app->appForm)) {
            $appForm = (string)$app->appForm;
            AppValidator::init($appForm);
        }
    }

    /**
     * Map domain name with app setting
     *
     * @throws Exception
     */
    private static function initWApp()
    {
        //Load WSetting configurations
        $prefix = self::NAMESPACE_PREFIX;
        $siteSettingLocation = W_ROOT . DIRECTORY_SEPARATOR
            . self::SITE_SETTING;
        $siteSetting = FileUtils::readXMLFile($siteSettingLocation, $prefix);
        if (empty($siteSetting->app)) {
            throw new Exception(
                'Could not init app, please check your configuration'
            );
        }

        /**
         * Get domain name from request. Then load app setting configurations.
         */
        $domain = HTTPRequest::getDomainName();

        AppInfo::$NAME = $domain;
        AppInfo::$REQ_DOMAIN = $domain;
        if (!empty($siteSetting->cacheEngine)) {
            Cache::init((string)$siteSetting->cacheEngine);
            self::$APP = Cache::get(self::CACHE_W_INIT);
        }

        if (!empty(self::$APP)) {
            self::$APP = json_decode(self::$APP);
            return;
        }

        //Init app by domain name
        $app = $siteSetting->xpath(
            "//{$prefix}:app[{$prefix}:domainName='{$domain}' or {$prefix}:domainAlias='{$domain}']"
        );

        //If domain not mapped with any app. Then check default app setting
        if ($app) {
            self::$APP = $app[0];
            return;
        }

        //Get default app
        if (empty($siteSetting->defaultApp)) {
            throw new Exception(
                'This domain has not been mapped to any app, please contact the Administrator'
            );
        }
        $defaultApp = (string)$siteSetting->defaultApp;
        $app = $siteSetting->xpath(
            "//{$prefix}:app[{$prefix}:appName='{$defaultApp}']"
        );
        if (!$app) {
            throw new Exception(
                'This domain has not been mapped to any app, please contact the Administrator'
            );
        }

        self::$APP = $app[0];
    }

    /**
     *
     */
    private static function storeAppToCache()
    {
        Cache::set(self::CACHE_W_INIT, json_encode(self::$APP));
    }
}