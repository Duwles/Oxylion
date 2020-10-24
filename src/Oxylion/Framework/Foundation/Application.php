<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Foundation;

class Application
{
    protected static ?Application $instance = null;

    public static function make(): Application
    {
        if (static::$instance===null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct() { }
    private function __clone()     { }
    protected function __wakeup()  { }
}