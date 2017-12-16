<?php
/**
 * Created by PhpStorm.
 * User: SH
 * Date: 7/8/2017
 * Time: 7:33 PM
 */

namespace core\processor;


use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use Exception;

final class System
{
    public static function run()
    {
        try {
            if (!method_exists('core\processor\AppsInitialize', 'initApp')) {
                throw new Exception(
                    'Could not init app, please check your configuration'
                );
            }
            AppsInitialize::initApp();
            AppRouting::runApp(new HTTPRequest(), new HTTPResponse());
        } catch (Exception $e) {
            exit('Caught Exception: ' . $e->getMessage());
        }
    }
}