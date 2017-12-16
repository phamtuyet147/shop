<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core;

use core\processor\System;
use Exception;

require_once __DIR__ . "/AutoLoad.php";

/**
 * Class main
 * Please should not edit this class if not needed
 *
 * @package core
 */
final class main
{

    /**
     * Main function of ww-source
     */
    public static function execute()
    {
        try {
            System::run();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

main::execute();