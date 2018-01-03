<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 12/17/2017
 * Time: 10:57 PM
 */

namespace core\utils;


class WForm
{
    private static $FORMS = array();
    private $form;

    /**
     * WForm constructor.
     *
     * @param $form
     */
    public function __construct($form, $data = array())
    {
        $this->form = $form;
        self::$FORMS[$form] = $data;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setArgument($name, $value)
    {
        self::$FORMS[$this->form][$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getArgument($name)
    {
        if (array_key_exists($name, self::$FORMS[$this->form])) {
            return self::$FORMS[$this->form][$name];
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getAllArguments()
    {
        return self::$FORMS[$this->form];
    }

    /**
     *
     */
    public function clearArguments()
    {
        unset(self::$FORMS[$this->form]);
    }

    /**
     * @param $form
     * @param $name
     *
     * @return mixed|null
     */
    public static function getFormArgument($form, $name)
    {
        if (!array_key_exists($form, self::$FORMS)) {
            return null;
        }
        if (!array_key_exists($name, self::$FORMS[$form])) {
            return null;
        }

        return self::$FORMS[$form][$name];
    }

    /**
     * @param $form
     *
     * @return mixed
     */
    public static function getFormToken($form)
    {
        if (empty(self::$FORMS[$form]['token'])) {
            self::$FORMS[$form]['token'] = HashUtil::randomHash();
        }

        return self::$FORMS[$form]['token'];
    }

}