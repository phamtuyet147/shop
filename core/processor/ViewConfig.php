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
use core\utils\FileUtils;
use core\utils\HashUtil;
use core\utils\HTTPRequest;
use core\utils\StringUtils;
use Exception;
use SimpleXMLElement;

final class ViewConfig
{
    const CACHE_VIEWS = 'wViews';
    const CACHE_PREFIX_VIEW = 'wView:';
    const PREFIX_NAMESPACE = 'av';
    const VIEW_NAMESPACE = 'http://linhnv.xyz/app.view_config';

    private static $cachedViewDirectory;
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
                self::$viewConfigFiles, 'view', AppInfo::$BASE_PATH
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
            self::storeCachedView($pagePath, self::$pageContext);
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
        self::storeCachedView($pagePath, self::$pageContext);
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
        $pageContext = self::getPartContent($layoutFile);

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
            $partContent = self::getPartContent($part);
            $viewPart = preg_quote($viewPart);
            $pattern = "/{w\:view\s+?" . $viewPart . "\s*?}/s";
            $pageContext = preg_replace(
                $pattern, $partContent, $pageContext
            );
        }

        $pageContext = self::parseView($pageContext);
        self::$pageContext = $pageContext;
    }

    /**
     * @param $file
     *
     * @return string
     * @throws Exception
     */
    private static function getPartContent($file)
    {
        $context = FileUtils::getFileContent($file);

        return $context;
    }

    /**
     * @param $context
     *
     * @return null|string|string[]
     * @throws Exception
     */
    private static function initFormValidation($context)
    {
        //Parse form validator
        $shortTags = AppConfiguration::$FW_CONFIG['shortTag'];
        $webForms = array();
        $prefix = $shortTags['prefix'];
        $dom = new \DOMDocument("1.0", "UTF-8");
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($context, 'HTML-ENTITIES', 'UTF-8'));
        $forms = $dom->getElementsByTagName('form');
        /**
         * @var \DOMNodeList $forms
         * @var \DOMElement  $form
         */
        foreach ($forms as $form) {
            $formName = $form->getAttribute('name');
            if (empty($formName)) {
                continue;
            }
            $fields = AppValidator::getFields($formName);
            if (!$fields) {
                $fields = array();
            }
            $webForms[$formName] = $fields;

            //Auto recover form field data

            //Auto recover form input data
            $inputs = $form->getElementsByTagName('input');
            /**
             * @var \DOMNameList $inputs
             * @var \DOMElement  $input
             */
            foreach ($inputs as $input) {
                $inputName = $input->getAttribute('name');
                if (empty($inputName)) {
                    continue;
                }
                $inputType = $input->getAttribute('type');
                if (empty($inputType)) {
                    $inputType = 'text';
                }
                $field = AppValidator::getField(
                    $formName, $inputName
                );
                $condition = array();
                if (!empty($field['condition'])) {
                    $condition = explode(',', (string)$field['condition']);
                }
                if (in_array('required', $condition)) {
                    $input->setAttribute('required', 'required');
                }
                $recovery = true;
                if (!empty($field['recover'])) {
                    $recovery = StringUtils::toBoolean(
                        (string)$field['recover']
                    );
                }
                if ($recovery) {
                    if ($inputType != 'radio' && $inputType != 'checkbox') {
                        $input->setAttribute(
                            'value',
                            '{' . $prefix . ':' . $shortTags['formData'] . ' '
                            . $formName . '.' . $inputName . '}'
                        );
                    } else {
                        $inputValue = $input->getAttribute('value');
                        if (empty($inputValue)) {
                            $inputValue = 'on';
                        }
                        $input->setAttribute(
                            'wOps',
                            '{' . $prefix . ':' . $shortTags['opsValue'] . ' '
                            . $formName . '.' . $inputName . ' ' . $inputValue
                            . '}'
                        );
                    }
                }
            }

            //Auto recover form textarea data
            $inputs = $form->getElementsByTagName('textarea');
            /**
             * @var \DOMNameList $inputs
             * @var \DOMElement  $input
             */
            foreach ($inputs as $input) {
                $inputName = $input->getAttribute('name');
                if (empty($inputName)) {
                    continue;
                }
                $field = AppValidator::getField(
                    $formName, $inputName
                );
                $condition = array();
                if (!empty($field['condition'])) {
                    $condition = explode(',', (string)$field['condition']);
                }
                if (in_array('required', $condition)) {
                    $input->setAttribute('required', 'required');
                }
                $recovery = true;
                if (!empty($field['recover'])) {
                    $recovery = StringUtils::toBoolean(
                        (string)$field['recover']
                    );
                }
                if (!$recovery) {
                    continue;
                }

                $node = $dom->createTextNode(
                    '{' . $prefix . ':' . $shortTags['formData'] . ' '
                    . $formName . '.' . $inputName . '}'
                );
                $input->appendChild($node);
            }

            //Auto recover form textarea data
            $inputs = $form->getElementsByTagName('select');
            /**
             * @var \DOMNameList $inputs
             * @var \DOMElement  $input
             */
            foreach ($inputs as $input) {
                $inputName = $input->getAttribute('name');
                if (empty($inputName)) {
                    continue;
                }
                $field = AppValidator::getField(
                    $formName, $inputName
                );
                $condition = array();
                if (!empty($field['condition'])) {
                    $condition = explode(',', (string)$field['condition']);
                }
                if (in_array('required', $condition)) {
                    $input->setAttribute('required', 'required');
                }
                $recovery = false;
                if (!empty($field['recover'])) {
                    $recovery = StringUtils::toBoolean(
                        (string)$field['recover']
                    );
                }
                if (!$recovery) {
                    continue;
                }

                $options = $input->getElementsByTagName('option');
                /**
                 * @var \DOMNodeList $options
                 * @var \DOMElement  $option
                 */
                foreach ($options as $option) {
                    $inputValue = $option->getAttribute('value');
                    if (empty($inputValue)) {
                        $inputValue = 'on';
                    }
                    $option->setAttribute(
                        'wOps',
                        '{' . $prefix . ':' . $shortTags['selectValue'] . ' '
                        . $formName . '.' . $inputName . ' ' . $inputValue . '}'
                    );
                }
            }

            //Append form name field
            $node = $dom->createElement(
                'input'
            );
            $node->setAttribute('name', 'wFrmToken');
            $node->setAttribute('type', 'hidden');
            $node->setAttribute(
                'value', '{' . $prefix . ':' . $shortTags['formToken'] . ' '
                . $formName . '}'
            );
            $form->appendChild($node);
            $fields = AppValidator::getFields($formName);
            if (!$fields) {
                continue;
            }
        }

        $defaultMessageData = json_encode
        (
            AppValidator::getDefaultMessages(), 128
        );
        $customRules = AppValidator::getCustomerRules();
        $customRulesDom = dom_import_simplexml($customRules);
        $customRules = $customRulesDom->ownerDocument->saveXML(
            $customRulesDom->ownerDocument->documentElement
        );
        if (!empty($body)) {
            $customRules = htmlspecialchars(json_encode($customRules));
            $webForms = json_encode($webForms, 128);
            $scriptText
                = <<<JS
                WValidate.setForms({$webForms});
                var EXTERNAL_FRAGMENT;
                WValidate.setDefaultMessage({$defaultMessageData});
                WValidate.setCustomRules({$customRules});
JS;

            $script = $dom->createElement('script', $scriptText);
            $body = $dom->getElementsByTagName('body');
            /**
             * @var \DOMElement $body
             */
            $body = $body[0];
            $body->appendChild($script);
        }

        $context = urldecode(html_entity_decode($dom->saveHTML()));
        $context = preg_replace("/wOps=\"({.*?})\"/s", "$1", $context);
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
     * @throws Exception
     */
    private static function parseView($pageContext)
    {
        $pageContext = self::initFormValidation($pageContext);

        $shortTags = AppConfiguration::$FW_CONFIG['shortTag'];
        $prefix = $shortTags['prefix'];
        unset($shortTags['prefix']);
        $shortTagsPattern = implode('|', $shortTags);
        while (preg_match(
            "/{(\/?){$prefix}\:($shortTagsPattern)(\s(.*?))?}/s", $pageContext,
            $matches
        )) {
            $isClosed = !empty($matches[1]);
            $wKey = $matches[2];
            $config = '';
            if (count($matches) > 3) {
                $config = trim($matches[4]);
            }
            $replaceStr = $config;
            switch ($wKey) {
                case $shortTags['link']:
                    $explodeConfig = explode(' ', $replaceStr);
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
                    $replaceStr = '<?php echo \core\utils\DateUtil::parseDate($'
                        . $replaceStr . ', \'d-m-Y\')?>';
                    break;
                case $shortTags['datetime']:
                    $replaceStr = '<?php echo \core\utils\DateUtil::parseDate($'
                        . $replaceStr . ', \'d-m-Y H:i:s\')?>';
                    break;
                case $shortTags['list']:
                    $explodeConfig = explode(' ', $replaceStr);
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
                            $list = new \core\utils\ValueList(\'' . $listFile . '.xml\');
                            $list = $list->getAll();
                            echo \'<select ' . $otherConfig . '>\';
                            foreach($list as $item){
                                $selected = "";
                                if($item->key == \'' . $selectedValue . '\'){
                                    $selected = "selected";
                                }
                                echo \'<option \'. $selected .\' value="\',$item->key,\'">\',$item->value,\'</option>\';
                            }
                            echo \'</select>\';
                            ?>';
                    break;
                case $shortTags['text']:
                    $replaceStr = '<?php echo htmlentities($' . $replaceStr
                        . ')?>';
                    break;
                case $shortTags['msg']:
                    $replaceStr = '<?php echo _(\'' . $replaceStr . '\')?>';
                    break;
                case $shortTags['var']:
                    $replaceStr = '<?php echo $' . $replaceStr . '?>';
                    break;
                case $shortTags['opsValue']:
                    $explodeConfig = explode(' ', $config);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $fieldInfo = $explodeConfig[0];
                    $fieldValue = $explodeConfig[1];
                    $explodeConfig = explode('.', $fieldInfo);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $form = $explodeConfig[0];
                    $fieldName = $explodeConfig[1];
                    $replaceStr
                        = "<?php echo \core\utils\WForm::getFormArgument('{$form}', '{$fieldName}') == '{$fieldValue}' ? 'checked' : ''?>";
                    break;
                case $shortTags['selectValue']:
                    $explodeConfig = explode(' ', $config);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $fieldInfo = $explodeConfig[0];
                    $fieldValue = $explodeConfig[1];
                    $explodeConfig = explode('.', $fieldInfo);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $form = $explodeConfig[0];
                    $fieldName = $explodeConfig[1];
                    $replaceStr
                        = "<?php echo \core\utils\WForm::getFormArgument('{$form}', '{$fieldName}') == '{$fieldValue}' ? 'selected' : ''?>";
                    break;
                case $shortTags['formData']:
                    $explodeConfig = explode('.', $config);
                    if (count($explodeConfig) < 2) {
                        break;
                    }
                    $form = $explodeConfig[0];
                    $fieldName = $explodeConfig[1];
                    $replaceStr
                        = "<?php echo \core\utils\WForm::getFormArgument('{$form}', '{$fieldName}')?>";
                    break;
                case $shortTags['function']:
                    if ($isClosed) {
                        $replaceStr = "<?php } ?>";
                        break;
                    }
                    $replaceStr = "<?php {$config} ?>";
                    break;
                case $shortTags['formToken']:
                    $replaceStr
                        = "<?php echo \core\utils\WForm::getFormToken('{$config}')?>";
                    break;
                case $shortTags['action']:
                    $replaceStr
                        = '<?php $wActionObject = new ' . $config
                        . '(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()); $wActionObject->doGet(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse(), new \core\app\AppView(new \core\utils\HTTPRequest(), new \core\utils\HTTPResponse()))?>';
                    break;
            }
            $parseKey = preg_quote($config);
            if (!$isClosed) {
                $pattern = "/{{$prefix}\:{$wKey}\s+?{$parseKey}\s*?}/s";
            } else {
                $pattern = "/{\/{$prefix}\:{$wKey}}/s";
            }
            $pageContext = preg_replace(
                $pattern, $replaceStr, $pageContext
            );
        }

        return $pageContext;
    }

    /**
     * @param mixed $cachedViewDirectory
     */
    public static function setCachedViewDirectory($cachedViewDirectory)
    {
        self::$cachedViewDirectory = $cachedViewDirectory;
    }

    private static function parseHashView($pagePath)
    {
        $filePath = explode('/', $pagePath);
        $fileName = array_pop($filePath);
        $fileName = HashUtil::getHash($fileName, 'md5') . '.php';
        $filePath[] = $fileName;
        $filePath = self::$cachedViewDirectory . DIRECTORY_SEPARATOR . trim(
                implode(DIRECTORY_SEPARATOR, $filePath), DIRECTORY_SEPARATOR
            );

        return $filePath;
    }

    /**
     * @param $pagePath
     *
     * @return array|bool|string
     */
    public static function loadCachedView($pagePath)
    {
        $filePath = self::parseHashView($pagePath);
        if (!file_exists($filePath)) {
            return false;
        }

        return $filePath;
    }

    /**
     * @param $pagePath
     * @param $context
     */
    private static function storeCachedView($pagePath, $context)
    {
        $filePath = self::parseHashView($pagePath);
        FileUtils::writeTruncateFile($context, $filePath);
    }
}