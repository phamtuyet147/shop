<?php
/**
 * Created by PhpStorm.
 * User: linhnguyen
 * Date: 9/14/17
 * Time: 10:35 AM
 */

namespace core\app;


use core\processor\AppRouting;
use core\processor\AppValidator;
use core\processor\Filters;
use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\LangUtil;
use Exception;
use SimpleXMLElement;

class FormValidationFilter implements AppFilter
{
    /**
     * @param HTTPRequest  $request
     * @param HTTPResponse $response
     * @param Filters      $filters
     *
     */
    public function doFilter(HTTPRequest $request, HTTPResponse $response,
        Filters $filters
    ) {
        try {
            $mappedForm = AppValidator::getMappedForm();
            $fields = AppValidator::getFields($mappedForm);
            $errorAction = AppValidator::getErrorAction();

            if (!$request->isPost() || !$fields) {
                $filters->nextFilter();
                return;
            }
            if (!isset($fields->field)) {
                $filters->nextFilter();
                return;
            }
            foreach ($fields->field as $field) {
                if (empty($field['condition']) || empty($field['name'])) {
                    continue;
                }
                $field = simplexml_load_string($field->asXML());
                $fieldName = (string)$field['name'];
                $conditions = (string)$field['condition'];
                $conditions = explode(',', $conditions);
                foreach ($conditions as $conditionType) {
                    $conditionType = trim($conditionType);
                    $argument = $field->xpath("//args[@for='{$fieldName}']");
                    if ($argument) {
                        $argument = $argument[0];
                        $argument = simplexml_load_string($argument->asXML());
                    }
                    $isValid = $this->checkValid(
                        $fieldName, $conditionType, $argument
                    );
                    if (!$isValid) {
                        if (!empty($errorAction)) {
                            $messages = $field->xpath(
                                "//msg[@for='{$fieldName}']"
                            );
                            if ($messages) {
                                $messages = $messages[0];
                                $messages = simplexml_load_string(
                                    $messages->asXML()
                                );
                            }
                            $errorMessage = $this->getMessage(
                                $fieldName, $conditionType, $messages, $argument
                            );
                            $action = $errorAction;
                            $action = trim($action, '/');
                            $action = '/' . $action;
                            $request->setRequestMethod();
                            $request->setPagePath($action);
                            $request->setAttribute('wError', $errorMessage);
                            AppRouting::runApp($request, $response);
                        }
                        return;
                    }
                }
            }
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
        $filters->nextFilter();
    }

    /**
     * @param string           $fieldName
     * @param string           $condition
     * @param SimpleXMLElement $args
     *
     * @return bool
     */
    private function checkValid($fieldName, $condition, $args)
    {
        $fieldValue = HTTPRequest::getParameter($fieldName);
        switch ($condition) {
            case 'required':
                if (empty($fieldValue)) {
                    return false;
                }
                break;
            case 'numeric':
                if (preg_match('/[^0-9]+/', $fieldValue)) {
                    return false;
                }
                break;
            case 'min':
                if (!$args || $args->children()) {
                    break;
                }
                $value = (string)$args;
                if ($fieldValue < $value) {
                    return false;
                }
                break;
            case 'max':
                if (!$args || $args->children()) {
                    break;
                }
                $value = (string)$args;
                if ($fieldValue > $value) {
                    return false;
                }
                break;
            case 'min-length':
                if (!$args || $args->children()) {
                    break;
                }
                $value = (string)$args;
                if (strlen($fieldValue) < strlen($value)) {
                    return false;
                }
                break;
            case 'max-length':
                if (!$args || $args->children()) {
                    break;
                }
                $value = (string)$args;
                if (strlen($fieldValue) > strlen($value)) {
                    return false;
                }
                break;
            case 'pattern':
                if (!$args || $args->children()) {
                    break;
                }
                $value = (string)$args;
                if (!preg_match($value, $fieldValue)) {
                    return false;
                }
                break;
            case 'match':
                if (!$args || $args->children()) {
                    break;
                }
                $matchField = (string)$args;
                $matchFieldValue = HTTPRequest::getParameter($matchField);
                if ($fieldValue != $matchFieldValue) {
                    return false;
                }
                break;
            default:
                if ($fieldValue == '') {
                    break;
                }
                $customRules = AppValidator::getCustomerRules();
                $prefix = AppValidator::NAMESPACE_PREFIX;
                $pattern = $customRules->xpath(
                    "//{$prefix}:rule[{$prefix}:key='{$condition}']/{$prefix}:pattern"
                );
                if (!$pattern) {
                    break;
                }
                $pattern = (string)$pattern[0];
                if (!preg_match($pattern, $fieldValue)) {
                    return false;
                }
                break;
        }
        return true;
    }

    /**
     * @param string           $fieldName
     * @param string           $condition
     * @param SimpleXMLElement $message
     * @param SimpleXMLElement $arguments
     *
     * @return mixed|string
     */
    private function getMessage($fieldName, $condition, $message, $arguments
    ) {
        if ($message && (isset($message['text']) || $message->children())) {
            $messageReturn = (string)$message['text'];
        } else {
            $defaultMessages = AppValidator::getDefaultMessages();
            if (array_key_exists($condition, $defaultMessages)) {
                $messageReturn = $defaultMessages[$condition];
            } else {
                $messageReturn = $defaultMessages['default'];
            }
        }
        if (preg_match('/{w\:msg(.*?)}/s', $messageReturn, $matches)) {
            $key = $matches[1];
            $key = trim($key);
            $messageReturn = LangUtil::getMessage($key);
        }
        while (preg_match('/\(([0-9]+)\)/', $messageReturn, $match)) {
            $replaceValue = $match[0];
            $flag = (int)$match[1];
            if ($message) {
                $msg = $message->xpath("//flag[@id={$flag}]");
                $replaceValue = (string)$msg[0];
            } else {
                switch ($match[1]) {
                    case '1':
                        $replaceValue = $fieldName;
                        break;
                    case '2':
                        if (!$arguments->children()) {
                            $replaceValue = (string)$arguments;
                        }
                        break;
                }
            }
            $messageReturn = str_replace(
                $match[0], $replaceValue, $messageReturn
            );
        }
        return $messageReturn;
    }
}