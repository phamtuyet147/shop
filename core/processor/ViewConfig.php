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
        $hasForm = preg_match_all(
            '/<form.*?<\/form>/s',
            $context, $forms
        );
        if (!$hasForm) {
            return $context;
        }
        $forms = $forms[0];
        foreach ($forms as $form) {
            if (!preg_match(
                '/<form[^>]+name="(\w+)"[^>]?/s', $form, $matches
            )
            ) {
                continue;
            }
            $replaceForm = $form;
            $formName = $matches[1];
            $fields = AppValidator::getFields($formName);
            if (!$fields) {
                $fields = array();
            }
            $webForms[$formName] = $fields->asXML();

            //Auto recover form field data

            //Auto recover form input data
            $hasInput = preg_match_all(
                '/<(input|textarea}select).*?>/s',
                $context, $matchedInputs
            );
            if ($hasInput) {
                $inputs = $matchedInputs[0];
                foreach ($inputs as $index => $input) {
                    $inputTag = $matchedInputs[1][$index];
                    if (!preg_match(
                        "/<{$inputTag}[^>]+name=\"(\w+)\"[^>]?/s", $input,
                        $matches
                    )
                    ) {
                        continue;
                    }
                    $replaceStr = $input;
                    $inputName = $matches[1];
                    $field = AppValidator::getField(
                        $formName, $inputName
                    );
                    $condition = array();
                    if (!empty($field['condition'])) {
                        $condition = explode(
                            ',', (string)$field['condition']
                        );
                    }
                    if (in_array('required', $condition)) {
                        if (!preg_match(
                            "/<{$inputTag}[^>]+required[^>]?/s", $input
                        )
                        ) {
                            $replaceStr = str_replace(
                                '>', ' required="required">', $input
                            );
                        }
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
                    if ($inputTag == 'input') {
                        $inputType = 'text';
                        if (preg_match(
                            '/<input[^>]+type="(\w+)"[^>]?/s', $input, $matches
                        )
                        ) {
                            $inputType = $matches[1];
                        }
                        if ($inputType != 'radio'
                            && $inputType != 'checkbox'
                        ) {
                            if (!preg_match(
                                '/<input[^>]+value=[^>]?/s', $input
                            )
                            ) {
                                $replaceStr = str_replace(
                                    '>',
                                    " value=\"<?php echo \core\utils\WForm::getFormArgument('{$formName}', '{$inputName}')?>\">",
                                    $replaceStr
                                );
                            }
                        } else {
                            $inputValue = 'on';
                            if (preg_match(
                                '/<input[^>]+value=\"(.*?)\"[^>]?/s',
                                $input,
                                $matches
                            )
                            ) {
                                $inputValue = $matches[1];
                            }
                            if (!preg_match(
                                '/<input[^>]+checked[^>]?/s', $input,
                                $matches
                            )
                            ) {
                                $replaceStr = str_replace(
                                    '>',
                                    " value=\"<?php echo \core\utils\WForm::getFormArgument('{$formName}', '{$inputName}') == '{$inputValue}' ? 'checked' : ''?>\">",
                                    $replaceStr
                                );
                            }
                        }
                    }
                    if ($inputTag == 'textarea') {
                        if (!preg_match(
                            '/<textarea.*?>.+</s', $input,
                            $matches
                        )
                        ) {
                            $replaceStr = str_replace(
                                '>',
                                "><?php echo \core\utils\WForm::getFormArgument('{$formName}', '{$inputName}') ?>",
                                $replaceStr
                            );
                        }
                    }
                    /*if ($inputTag == 'select') {
                        $options = $input->getElementsByTagName('option');
                        foreach ($options as $option) {
                            $inputValue = $option->getAttribute('value');
                            if (empty($inputValue)) {
                                $inputValue = 'on';
                            }
                            $option->setAttribute(
                                'wOps',
                                '{' . $prefix . ':' . $shortTags['selectValue']
                                . ' '
                                . $formName . '.' . $inputName . ' '
                                . $inputValue
                                . '}'
                            );
                        }
                    }*/
                    $replaceForm = str_replace(
                        $input, $replaceStr, $replaceForm
                    );
                }
                $context = str_replace($form, $replaceForm, $context);
            }
        }

        $defaultMessageData = json_encode(
            AppValidator::getDefaultMessages(), 128
        );
        $customRules = AppValidator::getCustomerRules();
        $customRulesDom = dom_import_simplexml($customRules);
        $customRules = $customRulesDom->ownerDocument->saveXML(
            $customRulesDom->ownerDocument->documentElement
        );
        $customRules = json_encode($customRules, 128);
        $webForms = json_encode($webForms, 128);
        $scriptText
            = <<<HTML
                <script type="text/javascript">
                WValidate.setForms({$webForms});
                var EXTERNAL_FRAGMENT;
                WValidate.setDefaultMessage({$defaultMessageData});
                WValidate.setCustomRules({$customRules});
                </script>
HTML;
        $context = str_replace('</body>', "{$scriptText}</body>", $context);
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
    private
    static function parseView($pageContext
    ) {
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
    public
    static function setCachedViewDirectory($cachedViewDirectory
    ) {
        self::$cachedViewDirectory = $cachedViewDirectory;
    }

    private
    static function parseHashView($pagePath
    ) {
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
    public
    static function loadCachedView($pagePath
    ) {
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
    private
    static function storeCachedView($pagePath, $context
    ) {
        $filePath = self::parseHashView($pagePath);
        FileUtils::writeTruncateFile($context, $filePath);
    }
}