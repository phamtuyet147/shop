<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/9/2017
 * Time: 5:17 PM
 */

namespace core\processor;

use core\app\AppController;
use core\app\AppView;
use core\utils\AppInfo;
use core\utils\Cache;
use core\utils\FileUtils;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\WForm;
use Exception;
use SimpleXMLElement;

final class AppRouting
{
    const PREFIX_NAMESPACE = 'r';
    const ROUTE_NAMESPACE = 'http://linhnv.xyz/app.mapping';
    const CACHE_ROUTES = 'wRoutes';
    const CACHE_PREFIX_ROUTE = 'wRoute:';

    private static $routingFiles = array();
    private static $ROUTES = '';

    /**
     * @param $mappingFiles
     */
    public static function init($mappingFiles)
    {
        $mappingFiles = explode(',', $mappingFiles);
        self::$routingFiles = $mappingFiles;
    }

    /**
     *
     * @throws Exception
     */
    public static function initRoutes()
    {
        if (!empty(self::$ROUTES)) {
            return;
        }
        $routes = Cache::get(self::CACHE_ROUTES);
        if ($routes) {
            self::$ROUTES = $routes;
            return;
        }

        $routes = FileUtils::readMultipleXMLFile(
            self::$routingFiles, 'routes', AppInfo::$BASE_PATH
        );
        $routes = $routes->asXML();
        Cache::set(self::CACHE_ROUTES, $routes);
        self::$ROUTES = $routes;
    }

    /**
     * @param $pagePath
     *
     * @return array|string
     * @throws Exception
     */
    private static function initFilters($pagePath)
    {
        $prefix = self::PREFIX_NAMESPACE;
        $routedFilters = array();
        $routes = simplexml_load_string(self::$ROUTES);
        $routes->registerXPathNamespace($prefix, self::ROUTE_NAMESPACE);

        $ext = '';
        $pathContainers = explode('/', $pagePath);
        $page = end($pathContainers);
        $pageExplode = explode('.', $page);
        if (count($pageExplode) > 1) {
            $ext = end($pageExplode);
        }
        $pagePath = trim($pagePath, '/');
        $xpath
            = "//{$prefix}:filter[{$prefix}:pattern='{$pagePath}' or {$prefix}:pattern='/{$pagePath}']";
        for ($i = count($pathContainers) - 1; $i >= 0; $i--) {
            $filters = $routes->xpath($xpath);
            if ($filters) {
                foreach ($filters as $filter) {
                    if (!isset($filter->action)
                        || in_array(
                            $filter->action, $routedFilters
                        )
                    ) {
                        continue;
                    }
                    $routedFilters[] = (string)$filter->action;
                }
            }
            unset($pathContainers[$i]);
            $pagePath = implode('/', $pathContainers) . '/*';
            $pagePath = trim($pagePath, '/');
            $xpath
                = "//{$prefix}:filter[{$prefix}:pattern='{$pagePath}' or {$prefix}:pattern='/{$pagePath}'";
            if (!empty($ext)) {
                $xpath .= " or {$prefix}:pattern='{$pagePath}.{$ext}' or {$prefix}:pattern='/{$pagePath}.{$ext}'";
            }
            $xpath .= ']';
        }

        return $routedFilters;
    }

    /**
     * @param $pagePath
     *
     * @return bool|SimpleXMLElement
     */
    private static function initController($pagePath)
    {
        $prefix = self::PREFIX_NAMESPACE;

        $routes = simplexml_load_string(self::$ROUTES);
        $routes->registerXPathNamespace($prefix, self::ROUTE_NAMESPACE);

        $pathContainers = explode('/', $pagePath);
        $page = end($pathContainers);
        $pageExplode = explode('.', $page);
        if (count($pageExplode) > 1) {
            $ext = end($pageExplode);
        }
        $pagePath = trim($pagePath, '/');
        $xpath
            = "//{$prefix}:controller[{$prefix}:pattern='{$pagePath}' or {$prefix}:pattern='/{$pagePath}']";
        for ($i = count($pathContainers) - 1; $i >= 0; $i--) {
            $controllers = $routes->xpath($xpath);
            if ($controllers) {
                return $controllers[0];
            }
            unset($pathContainers[$i]);
            $pagePath = implode('/', $pathContainers) . '/*';
            $pagePath = trim($pagePath, '/');
            $xpath
                = "//{$prefix}:controller[{$prefix}:pattern='{$pagePath}' or {$prefix}:pattern='/{$pagePath}'";
            if (!empty($ext)) {
                $xpath .= " or {$prefix}:pattern='{$pagePath}.{$ext}' or {$prefix}:pattern='/{$pagePath}.{$ext}'";
            }
            $xpath .= ']';
        }

        return false;
    }

    /**
     * @param $controller
     */
    private static function initFormValidation($controller)
    {
        if (empty($controller->form)) {
            return;
        }
        AppValidator::setMappedForm((string)$controller->form);
        if (!empty($controller->error)) {
            AppValidator::setErrorAction((string)$controller->error);
        }
    }

    /**
     * @param $pagePath
     *
     * @return array|bool|mixed|string
     * @throws Exception
     */
    public static function initRoute($pagePath)
    {
        $asteriskRoutePattern
            = '/' . preg_quote(
                AppConfiguration::$FW_CONFIG['asteriskRouteOpenTag']
            ) . '[\p{L}\pN-_\/]*'
            . preg_quote(AppConfiguration::$FW_CONFIG['asteriskRouteCloseTag'])
            . '/';
        $pagePath = preg_replace($asteriskRoutePattern, '*', $pagePath);

        //Get filter and controller from cache
        $routed = Cache::get(self::CACHE_PREFIX_ROUTE . $pagePath);

        if (!$routed) {
            //Load all route config
            self::initRoutes();
            //Init filters fot request
            $routedFilters = self::initFilters($pagePath);

            //Init controller for request
            $routedController = self::initController($pagePath);
            if (!$routedController) {
                throw new Exception("Could not find routing for {$pagePath}");
            }

            $routedController = $routedController->asXML();
            $routed = array(
                'controller' => $routedController,
                'filters'    => $routedFilters
            );

            Cache::set(
                self::CACHE_PREFIX_ROUTE . $pagePath, json_encode($routed)
            );
        } else {
            $routed = json_decode($routed, true);
        }

        return $routed;
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     *
     * @throws Exception
     */
    public static function firstRunApp(HTTPRequest $request,
        HTTPResponse $response
    ) {
        $pagePath = $request->getPagePath();

        $routed = self::initRoute($pagePath);

        $routedFilters = $routed['filters'];
        $routedController = $routed['controller'];

        $routedController = simplexml_load_string($routedController);

        self::initFormValidation($routedController);

        $filter = new Filters($routedFilters);
        $filter->nextFilter();
        if (!$filter->isCompleted()) {
            throw new Exception(
                'You are not permitted to access this link, please contact the administrator for more information'
            );
        }

        if (empty($routedController->action)) {
            throw new Exception('Could not init controller: ' . $pagePath);
        }
        $controllerClass = (string)$routedController->action;
        if (!class_exists($controllerClass)) {
            throw new Exception('Could not find controller');
        }

        self::runController($routedController, $request, $response);
    }

    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     *
     * @throws Exception
     */
    public static function runApp(HTTPRequest $request, HTTPResponse $response)
    {
        $pagePath = $request->getPagePath();

        $routed = self::initRoute($pagePath);

        $routedController = $routed['controller'];

        $routedController = simplexml_load_string($routedController);

        self::initFormValidation($routedController);

        if (empty($routedController->action)) {
            throw new Exception('Could not init controller: ' . $pagePath);
        }
        self::runController($routedController, $request, $response);
    }

    /**
     * @param              $routedController
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     *
     * @throws Exception
     */
    private static function runController($routedController,
        HTTPRequest $request, HTTPResponse $response
    ) {
        $pagePath = $request->getPagePath();

        $controllerClass = (string)$routedController->action;
        if (!class_exists($controllerClass)) {
            throw new Exception('Could not find controller');
        }
        $appView = new AppView(new HTTPRequest(), new HTTPResponse());
        if (isset($routedController->views)) {
            $appView->setViews($routedController->views[0]);
        }
        if (isset($routedController->params)) {
            self::initPageParams($routedController->params);
        }
        if (isset($routedController->bind)) {
            self::bindParams($pagePath, (string)$routedController->bind);
        }

        /** @var AppController $controllerClass */
        $controllerClass = new $controllerClass($request, $response);
        if (!method_exists($controllerClass, 'doGet')
            && !method_exists(
                $controllerClass, 'doPost'
            )
        ) {
            throw new Exception(
                'Fail to init controller for this path: ' . $pagePath
            );
        }

        //Bind post params to form
        if (!empty($routedController->form)) {
            new WForm(
                (string)$routedController->form, $request->getParameters()
            );
        }

        if ($request->isPost() && $request->getRealPagePath() == $pagePath) {
            $controllerClass->doPost($request, $response, $appView);
        } else {
            $controllerClass->doGet($request, $response, $appView);
        }
    }

    /**
     * @param SimpleXMLElement $params
     *
     * @throws Exception
     */
    private static function initPageParams($params)
    {
        foreach ($params as $param) {
            if (empty($param['name']) || empty($param['value'])) {
                throw new Exception("Could not init param {$param->asXML()}");
            }
            HTTPRequest::setGetParam(
                (string)$param['name'], (string)$param['value']
            );
        }
    }

    private static function bindParams($pagePath, $bindStr)
    {
        $bindParams = explode(',', $bindStr);
        $requests = explode('/', $pagePath);
        foreach ($bindParams as $paramKey) {
            $paramValue = array_pop($requests);
            HTTPRequest::setGetParam($paramKey, $paramValue);
        }
    }
}