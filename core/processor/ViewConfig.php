<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/16/2017
 * Time: 5:30 PM
 */

namespace core\processor;


use core\utils\AppInfo;
use core\utils\Cache;
use core\utils\DateUtil;
use core\utils\FileUtils;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\LangUtil;
use core\utils\ValueList;
use Exception;
use SimpleXMLElement;

final class ViewConfig
{
    const CACHE_VIEWS = 'wViews';
    const CACHE_PREFIX_VIEW = 'wView:';
    const PREFIX_NAMESPACE = 'av';
    const VIEW_NAMESPACE = 'http://linhnv.xyz/app.view_config';

    private static $viewConfigFiles;
    private static $pageContext = '';
    /**
     * @var SimpleXMLElement $APP_VIEWS
     */
    private static $APP_VIEWS;

    /**
     * @param $viewConfigFiles
     */
    public static function init($viewConfigFiles)
    {
        $viewConfigFiles = explode(',', $viewConfigFiles);
        self::$viewConfigFiles = $viewConfigFiles;
    }

    /**
     *
     * @throws Exception
     */
    private static function initAppViews()
    {
        if (!empty(self::$APP_VIEWS)) {
            return;
        }

        $appViews = Cache::get(self::CACHE_VIEWS);
        if (!$appViews) {
            $appViews = FileUtils::readMultipleXMLFile(
                self::$viewConfigFiles, 'views', AppInfo::$BASE_PATH
            );
            Cache::set(self::CACHE_VIEWS, $appViews->asXML());
        } else {
            $appViews = simplexml_load_string($appViews);
        }

        $appViews->registerXPathNamespace(
            self::PREFIX_NAMESPACE, self::VIEW_NAMESPACE
        );
        self::$APP_VIEWS = $appViews;
    }

    /**
     * @param $pagePath
     *
     * @throws Exception
     */
    public static function initView($pagePath)
    {
        $routedView = Cache::get(self::CACHE_PREFIX_VIEW . $pagePath);
        if ($routedView) {
            $routedView = simplexml_load_string($routedView);
            self::getPageContext($routedView);
            return;
        }

        $prefix = self::PREFIX_NAMESPACE;

        self::initAppViews();
        $appViews = self::$APP_VIEWS;

        $pathContainers = explode('/', $pagePath);
        $page = end($pathContainers);
        $pageExplode = explode('.', $page);
        if (count($pageExplode) > 1) {
            $ext = end($pageExplode);
        }
        $path = trim($pagePath, '/');
        $xpath = "//{$prefix}:view[@action='{$path}' or @action='/{$path}']";
        for ($i = count($pathContainers) - 1; $i >= 0; $i--) {
            $routedViews = $appViews->xpath($xpath);
            if ($routedViews) {
                $routedView = $routedViews[0];
                break;
            }
            unset($pathContainers[$i]);
            $path = implode('/', $pathContainers) . '/*';
            $xpath = "//{$prefix}:view[@action='{$path}' or @action='/{$path}'";
            $path = trim($path, '/');
            if (!empty($ext)) {
                $xpath .= " or @action='{$path}.{$ext}' or @action='/{$path}.{$ext}'";
            }
            $xpath .= ']';
        }

        if (!$routedView) {
            throw new Exception("Could not init view for {$pagePath}");
        }

        //Init view parts
        if (empty($routedView['layout'])) {
            throw new Exception(
                'Could not init layout for this view: ' . $pagePath
            );
        }
        $layout = (string)$routedView['layout'];
        $layout = self::initLayout($layout);

        if (isset($routedView->part)) {
            foreach ($routedView->part as $part) {
                if (empty($part['name']) || empty($part['file'])) {
                    throw new Exception('View configuration is wrong format');
                }
                $name = (string)$part['name'];
                $file = (string)$part['file'];
                $layoutPart = $layout->xpath("//part[@name='{$name}']");
                if ($layoutPart) {
                    $layoutPart[0]['file'] = $file;
                } else {
                    $newPart = $layout->addChild('part', $part);
                    $newPart->addAttribute('name', $name);
                    $newPart->addAttribute('file', $file);
                }
            }
        }

        Cache::set(self::CACHE_PREFIX_VIEW . $pagePath, $layout->asXML());
        self::getPageContext($layout);
    }

    /**
     * @param $layoutName
     *
     * @return SimpleXMLElement|SimpleXMLElement[]
     * @throws Exception
     */
    private static function initLayout($layoutName)
    {
        $prefix = self::PREFIX_NAMESPACE;
        $appViews = self::$APP_VIEWS;
        $layout = $appViews->xpath(
            "//{$prefix}:layouts/{$prefix}:layout[@name='{$layoutName}']"
        );
        if (!$layout) {
            throw new Exception('Could not init layout for this view');
        }
        $layout = $layout[0];
        $layout = simplexml_load_string($layout->asXML());
        if (!empty($layout['extend'])) {
            $layoutName = (string)$layout['name'];
            $parentLayout = self::initLayout($layoutName);
            foreach ($layout->part as $part) {
                if (empty($part['name']) || empty($part['file'])) {
                    continue;
                }
                $name = (string)$part['name'];
                $file = (string)$part['file'];
                $parentPart = $parentLayout->xpath("//part[@name='{$name}']");
                if ($parentPart) {
                    $parentPart[0]['file'] = $file;
                } else {
                    $newPart = $parentLayout->addChild('part', $part);
                    $newPart->addAttribute('name', $name);
                    $newPart->addAttribute('file', $file);
                }
            }

            $layout = $parentLayout;
        }

        return $layout;
    }

    /**
     * @param SimpleXMLElement $layout
     *
     * @throws Exception
     */
    private static function getPageContext(SimpleXMLElement $layout)
    {
        $layoutFile = $layout['layout'];
        $layoutFile = trim($layoutFile, '/');
        $layoutFile = AppInfo::$BASE_PATH . DIRECTORY_SEPARATOR
            . $layoutFile;
        if (!file_exists($layoutFile)) {
            throw new Exception('Could not find file: ' . $layoutFile);
        }

        //Parse attribute
        $attributes = HTTPRequest::getAttributes();
        extract($attributes);

        //Parse layout context
        $pageContext = FileUtils::getFileContent($layoutFile);

        //Parse view content
        while (preg_match(
            '/{w\:view(.*?)}/s', $pageContext, $view
        )) {
            $viewPart = $view[1];
            $viewPart = trim($viewPart);
            $part = $layout->xpath("./part[@name='{$viewPart}'][last()]");
            if (!$part) {
                throw new Exception('Miss view init in config file');
            }
            $part = $part[0];
            if (empty($part['file'])) {
                throw new Exception(
                    'Could not init file path for this part: ' . $viewPart
                );
            }
            $part = trim($part['file'], '/');
            $part = AppInfo::$BASE_PATH . DIRECTORY_SEPARATOR . $part;
            if (!file_exists($part)) {
                throw new Exception('Could not find file: ' . $part);
            }
            ob_start();
            /** @noinspection PhpIncludeInspection */
            include($part);
            $partContent = ob_get_contents();
            ob_end_clean();
            $viewPart = preg_quote($viewPart);
            $pattern = "/{w\:view\s+?" . $viewPart . "\s*?}/s";
            $pageContext = preg_replace(
                $pattern, $partContent, $pageContext
            );
        }

        //Parse form validator
        $webForms = Array();
        $hasForm = preg_match_all(
            '/<form[^>]+name="(\w+)"[^>]?/s',
            $pageContext, $forms
        );
        if ($hasForm) {
            $forms = $forms[1];
            foreach ($forms as $form) {
                $form = trim($form);
                $fields = AppValidator::getFields($form);
                if (!$fields) {
                    continue;
                }
                $webForms[$form] = $fields->asXML();
            }
        }
        $webFormsData = json_encode($webForms, 128);
        $defaultMessageData = json_encode
        (
            AppValidator::getDefaultMessages(), 128
        );
        $customRules = json_encode(
            AppValidator::getCustomerRules()->asXML(), 128
        );
        $scriptText
            = <<<HTML
                <script type="text/javascript">
                var EXTERNAL_FRAGMENT;WValidate.setForms({$webFormsData});
                WValidate.setDefaultMessage({$defaultMessageData});
                WValidate.setCustomRules({$customRules});
                </script>
HTML;
        $pageContext = str_replace(
            '</body>', $scriptText, $pageContext
        );

        $pageContext = self::parseView($pageContext);
        self::$pageContext = $pageContext;
        HTTPResponse::setContent($pageContext);
    }

    private static function getPartContent($file)
    {
        $context = FileUtils::getFileContent($file);
        $context = self::parseView($context);

        return $context;
    }

    /**
     * @param $pageContext
     *
     * @return mixed
     *
     * 'link'     => 'link',
     * 'date'     => 'date',
     * 'datetime' => 'datetime',
     * 'list'     => 'list',
     * 'text'     => 'text',
     * 'msg'      => 'msg',
     * 'var'      => 'var',
     * 'form'     => 'form',
     * 'function' => 'func'
     */
    private static function parseView($pageContext)
    {
        $shortTags = AppConfiguration::$FW_CONFIG['shortTag'];
        $prefix = $shortTags['prefix'];
        unset($shortTags['prefix']);
        $shortTagsPattern = implode('|', $shortTags);
        while (preg_match(
            "/{\\?{$prefix}\:($shortTagsPattern)(.*?)}/s", $pageContext,
            $matches
        )) {
            $wKey = $matches[1];
            $config = trim($matches[2]);
            $replaceStr = $config;
            switch ($wKey) {
                case $shortTags['link']:
                    $explodeConfig = explode(' ', $config);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $route = $explodeConfig[0];
                    $url = $explodeConfig[1];
                    $replaceStr = str_replace(
                        '*',
                        AppConfiguration::$FW_CONFIG['asteriskRouteOpenTag']
                        . $url
                        . AppConfiguration::$FW_CONFIG['asteriskRouteCloseTag'],
                        $route
                    );
                    break;
                case $shortTags['date']:
                    $replaceStr = DateUtil::parseDate($config, 'd-m-Y');
                    break;
                case $shortTags['datetime']:
                    $replaceStr = DateUtil::parseDate($config, 'd-m-Y H:i:s');
                    break;
                case $shortTags['list']:
                    $explodeConfig = explode(' ', $config);
                    $listFile = $explodeConfig[0];
                    $selectedValue = '';
                    unset($explodeConfig[0]);
                    if (count($explodeConfig) > 1) {
                        $selectedValue = $explodeConfig[1];
                        unset($explodeConfig[1]);
                    }
                    $otherConfig = implode(' ', $explodeConfig);
                    /** @noinspection PhpUndefinedVariableInspection */
                    $replaceStr
                        = '
                            <?php 
                            $list = new ValueList(\'' . $listFile . '.xml\');
                            $list = $list->getAll();
                            echo \'<select ' . $otherConfig . '>\';
                            foreach($list as $item){
                                $selected = "";
                                if($item->key == \'' . $selectedValue . '\'){
                                    $selected = "selected";
                                }
                                echo \'<option value="\',$item->key,\'">\',$item->value,\'</option>\';
                            }
                            echo \'</select>\';
                            ?>';
                    break;
                case $shortTags['text']:
                    $replaceStr = HTTPRequest::getAttribute($replaceStr);
                    $replaceStr = htmlentities($replaceStr);
                    break;
                case $shortTags['msg']:
                    $replaceStr = LangUtil::getMessage($replaceStr);
                    break;
                case $shortTags['var']:
                    $replaceStr = HTTPRequest::getAttribute($replaceStr);
                    break;
                case $shortTags['form']:
                    $replaceStr = HTTPRequest::getAttribute($replaceStr);
                    break;
            }
            $parseKey = preg_quote($config);
            $pattern = "/{{$prefix}\:{$wKey}\s+?{$parseKey}\s*?}/s";
            $pageContext = preg_replace(
                $pattern, $replaceStr, $pageContext
            );
        }

        return $pageContext;
    }
}