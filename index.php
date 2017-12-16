<?php
define("W_ROOT", __DIR__);
define("W_CORE", __DIR__ . "/core");
define("W_APPS", __DIR__ . "/apps");
define("W_RESOURCES", __DIR__ . "/resources");
define("W_LOG", __DIR__ . "/logs");

date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once(__DIR__ . '/core/main.php');
