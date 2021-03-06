<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Debug;

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
            ini_set('display_errors', "off");
        }
        elseif ($errorDisplay && (!ini_get('log_errors') || ini_get('error_log'))) {
            ini_set('display_errors', "on");
        }

    }
}