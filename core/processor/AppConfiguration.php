<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 10/22/2017
 * Time: 1:06 PM
 */

namespace core\processor;


use core\database\ConnectDatabaseInfo;
use core\utils\AppInfo;
use core\utils\Cache;
use core\utils\FileUtils;
use core\utils\HashUtil;
use core\utils\LangUtil;
use core\utils\Properties;
use core\utils\Resources;
use core\utils\SQLInstance;
use core\utils\StringUtils;
use Exception;

final class AppConfiguration
{
    const NAMESPACE_PREFIX = 'app';
    const DEFAULT_DB_PORT = '3306';

    public static $DEVELOPER_MODE = false;
    public static $FW_CONFIG
        = array(
            'asteriskRouteOpenTag'  => 'article',
            'asteriskRouteCloseTag' => 'wsource',
            'shortTag'              => array(
                'prefix'   => 'w',
                'link'     => 'link',
                'date'     => 'date',
                'datetime' => 'datetime',
                'list'     => 'list',
                'text'     => 'text',
                'msg'      => 'msg',
                'var'      => 'var',
                'form'     => 'form',
                'function' => 'func'
            )
        );

    /**
     * @param $configFile
     *
     * @throws Exception
     */
    public static function init($configFile)
    {
        $configFile = trim($configFile);
        $configFile = trim($configFile, '/');
        $configFile = AppInfo::$BASE_PATH . DIRECTORY_SEPARATOR . $configFile;
        $appConfig = FileUtils::readXMLFile(
            $configFile, self::NAMESPACE_PREFIX
        );
        self::initAppConfiguration($appConfig);
    }

    /**
     * Init main application configuration
     * - Init base working app directories
     * - Init app default Language
     * - Init app hash engine
     * - Init app connection info
     * - Init app Cache engine
     *
     * @param \SimpleXMLElement $appConfig
     *
     * @throws Exception
     */
    private static function initAppConfiguration($appConfig)
    {
        $absoluteAppDir = AppInfo::$BASE_PATH . DIRECTORY_SEPARATOR;
        /** @noinspection PhpUndefinedFieldInspection */
        if (empty($appConfig->directory)
            || empty($appConfig->directory->resources)
            || empty($appConfig->directory->properties)
            || empty($appConfig->directory->language)
            || empty($appConfig->directory->sql)
            || empty($appConfig->defaultLanguage)
            || empty($appConfig->hash)
            || empty($appConfig->hash->prefix)
            || empty($appConfig->hash->defaultHashType)
            || empty($appConfig->connection)
            || empty($appConfig->connection->hostname)
            || empty($appConfig->connection->databaseName)
            || empty($appConfig->connection->username)
            || empty($appConfig->connection->password)
        ) {
            throw new Exception('Configuration file is in wrong format');
        }

        Resources::setResourcesLocation(
            $absoluteAppDir . (string)$appConfig->directory->resources
        );

        Properties::setPropertiesLocation(
            $absoluteAppDir . (string)$appConfig->directory->properties
        );

        LangUtil::setLanguageLocation(
            $absoluteAppDir . (string)$appConfig->directory->language
        );

        SQLInstance::setSqlLocation(
            $absoluteAppDir . (string)$appConfig->directory->sql
        );

        /** @noinspection PhpUndefinedFieldInspection */
        LangUtil::setDefaultLanguage((string)$appConfig->defaultLanguage);
        LangUtil::init();

        /** @noinspection PhpUndefinedFieldInspection */
        HashUtil::init(
            (string)$appConfig->hash->prefix,
            (string)$appConfig->hash->defaultHashType
        );

        /** @noinspection PhpUndefinedFieldInspection */
        $connectionInfo = $appConfig->connection[0];
        $port = self::DEFAULT_DB_PORT;
        if (!empty($connectionInfo->port)) {
            $port = (string)$connectionInfo->port;
        }
        $hashType = null;
        if (!empty($connectionInfo->hashType)) {
            $hashType = (string)$connectionInfo->hashType;
        }
        $sqlEngine = null;
        if (!empty($connectionInfo->engine)) {
            $sqlEngine = (string)$connectionInfo->engine;
        }
        ConnectDatabaseInfo::initConnection(
            (string)$connectionInfo->hostname, $port,
            (string)$connectionInfo->databaseName,
            (string)$connectionInfo->username,
            (string)$connectionInfo->password, $hashType, $sqlEngine
        );

        $developerMode = self::$DEVELOPER_MODE;
        if (!empty($appConfig->developer)) {
            $developerMode = StringUtils::toBoolean($appConfig->developer);
            self::$DEVELOPER_MODE = $developerMode;
        }
        if ($developerMode) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            Cache::disconnect();
        }

        if (!empty($appConfig->resources)) {
            Resources::init((string)$appConfig->resources);
        }

        setlocale(LC_NUMERIC, 'en_US');

        if (!empty($appConfig->fwConfig)) {
            if (!empty($appConfig->fwConfig->asteriskRouteOpenTag)) {
                self::$FW_CONFIG['asteriskRouteOpenTag']
                    = (string)$appConfig->fwConfig->asteriskRouteOpenTag;
            }
            if (!empty($appConfig->fwConfig->asteriskRouteCloseTag)) {
                self::$FW_CONFIG['asteriskRouteCloseTag']
                    = (string)$appConfig->fwConfig->asteriskRouteCloseTag;
            }
            if (!empty($appConfig->fwConfig->shortTag)) {
                if (!empty($appConfig->fwConfig->shortTag->prefix)) {
                    self::$FW_CONFIG['shortTag']['prefix']
                        = (string)$appConfig->fwConfig->shortTag->prefix;
                }
                if (!empty($appConfig->fwConfig->shortTag->link)) {
                    self::$FW_CONFIG['shortTag']['link']
                        = (string)$appConfig->fwConfig->shortTag->link;
                }
                if (!empty($appConfig->fwConfig->shortTag->date)) {
                    self::$FW_CONFIG['shortTag']['date']
                        = (string)$appConfig->fwConfig->shortTag->date;
                }
                if (!empty($appConfig->fwConfig->shortTag->datetime)) {
                    self::$FW_CONFIG['shortTag']['datetime']
                        = (string)$appConfig->fwConfig->shortTag->datetime;
                }
                if (!empty($appConfig->fwConfig->shortTag->list)) {
                    self::$FW_CONFIG['shortTag']['list']
                        = (string)$appConfig->fwConfig->shortTag->list;
                }
                if (!empty($appConfig->fwConfig->shortTag->text)) {
                    self::$FW_CONFIG['shortTag']['text']
                        = (string)$appConfig->fwConfig->shortTag->text;
                }
                if (!empty($appConfig->fwConfig->shortTag->msg)) {
                    self::$FW_CONFIG['shortTag']['msg']
                        = (string)$appConfig->fwConfig->shortTag->msg;
                }
                if (!empty($appConfig->fwConfig->shortTag->var)) {
                    self::$FW_CONFIG['shortTag']['var']
                        = (string)$appConfig->fwConfig->shortTag->var;
                }
                if (!empty($appConfig->fwConfig->shortTag->form)) {
                    self::$FW_CONFIG['shortTag']['form']
                        = (string)$appConfig->fwConfig->shortTag->form;
                }
                if (!empty($appConfig->fwConfig->shortTag->function)) {
                    self::$FW_CONFIG['shortTag']['function']
                        = (string)$appConfig->fwConfig->shortTag->function;
                }
            }
        }
    }
}