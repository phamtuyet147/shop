<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 9/29/2017
 * Time: 6:28 AM
 */

namespace core\processor;


use core\utils\AppInfo;
use core\utils\Cache;
use core\utils\FileUtils;
use SimpleXMLElement;

final class AppValidator
{
    const CACHE_VALIDATION_FORM_PREFIX = 'wValidation:';
    const CACHE_VALIDATION_RULES = 'wValidations';
    const VALIDATION_NAMESPACE = 'http://linhnv.xyz/forms';
    const NAMESPACE_PREFIX = 'wv';
    const CUSTOM_RULE_FILE = 'libraries/w_validator.xml';

    /**
     * @var SimpleXMLElement $CUSTOM_RULES
     */
    private static $CUSTOM_RULES;
    private static $DEFAULT_MESSAGES
        = Array(
            'required' => '{w:msg Field (1) is required}',
            'numeric' => '{w:msg Field (1) is not a numeric}',
            'min' => '{w:msg Field (1) must be greater than (2)}',
            'max' => '{w:msg Field (1) must be less than (2)}',
            'min-length' => '{w:msg Field (1) must be at least (2) characters}',
            'max-length' => '{w:msg Field (1) could not be longer than (2) characters}',
            'pattern' => '{w:msg Field (1) is not valid}',
            'match' => '{w:msg Fields (1) and (2) are not match}',
            'default' => '{w:msg Fields (1) is not valid}'
        );

    /**
     * @var SimpleXMLElement $FORMS
     */
    private static $FORMS;
    private static $validationFiles;
    private static $mappedForm;
    private static $errorAction;

    /**
     * @param $validationFiles
     */
    public static function init($validationFiles)
    {
        $validationFiles = explode(',', $validationFiles);
        self::$validationFiles = $validationFiles;
        if (empty(self::$CUSTOM_RULES)) {
            $customFile = W_CORE . DIRECTORY_SEPARATOR . self::CUSTOM_RULE_FILE;
            $customRules = FileUtils::readXMLFile($customFile, self::NAMESPACE_PREFIX);
            self::$CUSTOM_RULES = $customRules;
        }
    }

    /**
     *
     * @throws \Exception
     */
    public static function initForms()
    {
        if (!empty(self::$FORMS)) {
            return;
        }

        $forms = Cache::get(self::CACHE_VALIDATION_RULES);
        if (!$forms) {
            $forms = FileUtils::readMultipleXMLFile(self::$validationFiles, 'forms', AppInfo::$BASE_PATH);
            Cache::set(self::CACHE_VALIDATION_RULES, $forms->asXML());
        } else {
            $forms = simplexml_load_string($forms);
        }

        $forms->registerXPathNamespace(self::NAMESPACE_PREFIX, self::VALIDATION_NAMESPACE);
        self::$FORMS = $forms;
    }

    /**
     * @return mixed
     */
    public static function getMappedForm()
    {
        return self::$mappedForm;
    }

    /**
     * @param mixed $mappedForm
     */
    public static function setMappedForm($mappedForm)
    {
        self::$mappedForm = $mappedForm;
    }

    /**
     * @return mixed
     */
    public static function getErrorAction()
    {
        return self::$errorAction;
    }

    /**
     * @param mixed $errorAction
     */
    public static function setErrorAction($errorAction)
    {
        self::$errorAction = $errorAction;
    }

    /**
     * @param $form
     *
     * @return bool|SimpleXMLElement
     */
    public static function getFields($form)
    {
        $prefix = self::NAMESPACE_PREFIX;
        $cacheKey = self::CACHE_VALIDATION_FORM_PREFIX . $form;
        $fields = Cache::get($cacheKey);
        if ($fields) {
            $fields = simplexml_load_string($fields);
            return $fields;
        }
        self::initForms();
        $forms = self::$FORMS;
        $fields = $forms->xpath("//{$prefix}:form[@name='$form']");
        if (!$fields) {
            return false;
        }
        $fields = $fields[0];
        return $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultMessages()
    {
        return self::$DEFAULT_MESSAGES;
    }

    /**
     * @return SimpleXMLElement
     */
    public static function getCustomerRules()
    {
        return self::$CUSTOM_RULES;
    }
}