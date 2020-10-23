<?php
namespace Oxylion\Component\Debug;

use const E_ALL;
use const PHP_SAPI;
use function ini_get;
use function ini_set;
use function error_reporting;

class Debug
{
    private static bool $state;


    public static function enable($reportingLevel = E_ALL, $errorDisplay = true) {
        if (static::$state) {
            return;
        }

        static::$state = true;

        if (null !== $reportingLevel) {
            error_reporting($reportingLevel);
        } else {
            error_reporting(E_ALL);
        }

        if ('cli' !== PHP_SAPI) {
            ini_set('display_errors', 0);
        }
        elseif ($errorDisplay && (!ini_get('log_errors') || ini_get('error_log'))) {
            ini_set('display_errors', 1);
        }

    }
}