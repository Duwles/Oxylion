<?php
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Framework\Container;

class Container implements ContainerInterface
{
    protected static ?ContainerInterface $instance = null;

    protected static array $container;

    public static function make()
    {
        if (null===static::$instance)
            static::$instance = new Container();

        return static::$instance;
    }

    protected function __construct() {}

    protected function __clone() {}

    protected function __wakeup() {}

    public function __unset($id) {
        if (isset(static::$container[$id])) {
            unset(static::$container[$id]);
        }
    }

    public function __isset($id)
    {
        return $this->has($id);
    }

    public function __get($id)
    {
        $tget = $this->get($id);
        return $tget;
    }

    public function __set($id, $value)
    {
        $this->set($id,$value);
    }

    public function has($id): bool
    {
        return isset(static::$container[$id]);
    }

    public function get($id)
    {
        return static::$container[$id];
    }

    public function getAll(): array
    {
        return static::$container;
    }

    public function set($id, $value)
    {
        static::$container[$id] = $value;
        return $this;
    }

    public function delete($id)
    {
        if($this->has($id)) {
            unset(static::$container[$id]);
        }
        return $this;
    }
}